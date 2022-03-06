<?php

namespace Hust\Service\Block;

use Hust\Service\Api\Data\ServiceInterface;
use Hust\Service\Model\ResourceModel\Locator;
use Hust\Service\Model\ResourceModel\Service\CollectionFactory;
use Hust\Service\Model\Service;
use Hust\Service\Model\System\UrlResolver;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class ListServices extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $serviceCollectionFactory;

    /**
     * @var UrlResolver
     */
    protected $urlResolver;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Locator
     */
    protected $resourceLocator;

    /**
     * ListServices constructor.
     * @param Locator $resourceLocator
     * @param Template\Context $context
     * @param UrlResolver $urlResolver
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $urlBuilder
     * @param CollectionFactory $serviceCollectionFactory
     * @param array $data
     */
    public function __construct(
        Locator $resourceLocator,
        Template\Context $context,
        UrlResolver $urlResolver,
        StoreManagerInterface $storeManager,
        UrlInterface $urlBuilder,
        CollectionFactory $serviceCollectionFactory,
        array $data = []
    ) {
        $this->resourceLocator = $resourceLocator;
        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
        $this->urlResolver = $urlResolver;
        $this->serviceCollectionFactory = $serviceCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getAllService()
    {
        $data = [];

        $serviceCollection = $this->serviceCollectionFactory->create();
        $serviceCollection->addFieldToFilter('is_active', 1)
            ->addOrder(ServiceInterface::POSITION, 'ASC');

//        if($postCode = $this->getRequest()->getParam('location')) {
//            $serviceId = $this->resourceLocator->getServiceByPostCode($postCode);
//            $serviceCollection->addFieldToFilter('service_id', ['in' => $serviceId]);
//        }

        if ($serviceCollection->getSize() > 0) {
            /** @var Service $service */
            foreach ($serviceCollection as $service) {
                $data[$service->getServiceId()] = [
                    'service_id' => $service->getServiceId(),
                    'title' => $service->getName(),
                    'short_description' => $service->getShortDescription(),
                    'content' => $service->getContent(),
                    'image' => $this->getMediaImage($service->getImage()),
                    'price' => $service->getCharge(),
                    'url' => $this->urlBuilder->getUrl('bookings/service', ['id' => $service->getServiceId()])
                ];
            }
        }

        return $data;
    }

    private function getMediaImage($name)
    {
        return $this->urlResolver->getImageUrlByName($name);
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getTitleImage()
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . UrlResolver::DIRECTORY_MEDIA . '/banner.jpg';
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        $this->_addBreadcrumbs();

        return parent::_prepareLayout();
    }

    private function _addBreadcrumbs()
    {
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );

            $breadcrumbsBlock->addCrumb(
                'warehouse',
                [
                    'label' => __('Booking'),
                ]
            );
        }
    }
}

