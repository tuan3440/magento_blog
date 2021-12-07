<?php
/**
 * Copyright © OpenTechiz, VietNam. All rights reserved.
 * See COPYING.txt for license details.
 * @package        OpenTechiz
 * @author         vuthuan <support@opentechiz.com>
 * @copyright      2021 Vu Thuan (03 2808 3090)
 */

namespace Dco\Service\Controller\Adminhtml\Calendar;


use Dco\Service\Model\LocatorFactory;
use Dco\Service\Model\ResourceModel\CalendarBooking\CollectionFactory;
use Dco\Service\Model\ServiceFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Customer\Model\CustomerFactory;
use Dco\Service\Helper\Data;
use Dco\Service\Model\Source\Hour;

class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    protected $collectionFactory;
    protected $customer;
    protected $helper;
    protected $locator;
    protected $service;
    protected $hour;

    public function __construct(Context $context,
                                Filter $filter,
                                CollectionFactory $collectionFactory,
                                CustomerFactory $customerFactory,
                                Data $helper,
                                ServiceFactory $serviceFactory,
                                LocatorFactory $locatorFactory,
                                Hour $hour
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->customer = $customerFactory;
        $this->helper = $helper;
        $this->locator = $locatorFactory;
        $this->service = $serviceFactory;
        $this->hour = $hour;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $statusValue = $this->getRequest()->getParam('status');
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setBookingStatus($statusValue);
            if ($statusValue == 1) {
                $this->helper->sendEmail();
            }
            if ($statusValue == 2) {
                $this->helper->sendEmail();
            }
            if ($statusValue == 3) {
                $customer = $this->customer->create()->load($item->getData("customer_id"));
                $customer->setData("point", (int)$customer->getData("point") + 1);
                $customer->save();
                $this->helper->sendEmail();
            }
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been modified.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }


}

