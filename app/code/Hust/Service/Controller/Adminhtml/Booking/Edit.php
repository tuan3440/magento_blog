<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;

class Edit extends Booking
{

    public function execute()
    {
        $bookingId = $this->getRequest()->getParam('booking_id');
        if ($bookingId) {
            try {
                $bookingRepo = $this->getBookingRepository()->getById($bookingId);
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage($e->getMessage());
                $this->_redirect('*/*');

                return;
            }
        }
        if (!$this->checkBooking($bookingId)) {
            $this->getMessageManager()->addErrorMessage(__("Error Permission"));
            $this->_redirect('*/*');
            return;
        }
        $this->getServiceRegistry()->register('booking_current', $bookingRepo);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_booking');
        $resultPage->getConfig()->getTitle()->prepend(__('Booking Manager'));
        $resultPage->addBreadcrumb(__('Booking'), __('Booking'));

        return $resultPage;
    }
}
