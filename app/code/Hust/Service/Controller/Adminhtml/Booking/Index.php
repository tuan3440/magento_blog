<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;
use Magento\Framework\App\ResponseInterface;

class Index extends Booking
{

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_booking');
        $resultPage->getConfig()->getTitle()->prepend(__('Booking Manager'));
        $resultPage->addBreadcrumb(__('Booking'), __('Booking'));

        return $resultPage;
    }
}
