<?php

namespace Hust\Service\Model\Notification;

use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\Url as CustomerUrlManager;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Locale\FormatInterface as LocaleFormat;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;


class BookingConfigProvider
{

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var CustomerSession
     */
    private $authSession;

    /**
     * @var FormKey
     */
    protected $formKey;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var UrlInterface
     */
    protected $helper;

    /**
     * View file system
     *
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $viewFileSystem;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;


    protected $bookingModel;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerModel;



    /**
     * @var \Webkul\Marketplace\Model\FeedbackFactory
     */
    protected $feedbackFactory;
    public function __construct(
        \Magento\Backend\Model\Auth\Session $authSession,
        FormKey $formKey,
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        UrlInterface $urlBuilder,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\View\Asset\Repository $viewFileSystem,
        \Magento\Backend\Helper\Data $adminHelper,
        \Hust\Service\Model\BookingFactory $bookingModel,
        \Magento\Customer\Model\CustomerFactory $customerModel
    ) {
        $this->authSession = $authSession;
        $this->formKey = $formKey;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
        $this->adminHelper = $adminHelper;
        $this->viewFileSystem = $viewFileSystem;
        $this->date = $date;
        $this->bookingModel = $bookingModel;
        $this->customerModel = $customerModel;
    }
    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $output = [];
        if ($this->isAdminLoggedIn()) {
            $defaultImageUrl = $this->viewFileSystem->getUrlWithParams(
                'Hust_Service::images/icons_notifications.png',
                []
            );
            $output['formKey'] = $this->formKey->getFormKey();
            $output['image'] = $defaultImageUrl;
            $output['sellerNotification'] = $this->getSellerNotificationData();
        }
        return $output;
    }


    /**
     * create newly created seller notification data.
     * @return array
     */
    protected function getSellerNotificationData()
    {
        $sellerData = [];
        $locator_id = $this->getCurrentUser()->getData('locator_id');

        $sellerCollection = $this->bookingModel->create()->getCollection()
            ->addFieldToFilter("locator_id", $locator_id)->addFieldToFilter('admin_notification', ['neq' => 0]);

        if ($sellerCollection->getSize()) {
            foreach ($sellerCollection as $seller) {
                $sellerData[] = [
                    'booking_id' => $seller->getBookingId(),
                ];
            }
        }
        return $sellerData;
    }

    private function isAdminLoggedIn()
    {
        return (bool)$this->authSession->isLoggedIn();
    }

    public function getCurrentUser()
    {
        return $this->authSession->getUser();
    }
}

