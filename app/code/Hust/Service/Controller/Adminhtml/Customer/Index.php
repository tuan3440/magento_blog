<?php

namespace Hust\Service\Controller\Adminhtml\Customer;

use Hust\Service\Controller\Adminhtml\Customer;
use Magento\Framework\App\ResponseInterface;

class Index extends Customer
{
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_booking_customer');
        $resultPage->getConfig()->getTitle()->prepend(__('Customer'));
        $resultPage->addBreadcrumb(__('Customer'), __('Customer'));

        return $resultPage;
    }
}
