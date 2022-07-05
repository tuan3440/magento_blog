<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;
use Hust\Service\Model\BookingFactory;
use Hust\Service\Model\Repository\BookingRepository;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;

class Index extends Booking
{

    public function __construct(Context $context, Session $session, PageFactory $resultPageFactory, BookingFactory $bookingFactory, BookingRepository $bookingRepository, ServiceRegistry $serviceRegistry, LayoutFactory $layoutFactory)
    {
        parent::__construct($context, $session, $resultPageFactory, $bookingFactory, $bookingRepository, $serviceRegistry, $layoutFactory);
    }

    public function execute()
    {
        $bookings = $this->getBookingFactory()->create()->getCollection()->addFieldToFilter('admin_notification', ['neq' => 0]);
        $this->updateNotification($bookings);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_booking');
        $resultPage->getConfig()->getTitle()->prepend(__('Booking Manager'));
        $resultPage->addBreadcrumb(__('Booking'), __('Booking'));

        return $resultPage;
    }

    private function updateNotification($bookings)
    {
        foreach ($bookings as $booking) {
            $booking->setAdminNotification(0);
            $booking->save();
        }
    }
}
