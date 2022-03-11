<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;

class Edit extends Booking
{

    public function execute()
    {
        $bookingId = $this->getRequest()->getParam('booking_id');
        $bookingRepo = $this->getBookingRepository()->getById($bookingId);
        $this->getServiceRegistry()->register('booking_current', $bookingRepo);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_booking');
        $resultPage->getConfig()->getTitle()->prepend(__('Booking Manager'));
        $resultPage->addBreadcrumb(__('Booking'), __('Booking'));

        return $resultPage;
    }
}
