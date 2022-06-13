<?php

namespace Hust\Service\Block\Adminhtml\Booking;

use Magento\Framework\View\Element\Template;
use Hust\Service\Model\Repository\BookingRepository;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Model\Repository\LocatorRepository;

class Pdf extends \Magento\Framework\View\Element\Template
{
    protected $booking;
    protected $locator;
    protected $service;

    public function __construct(Template\Context $context,
                                BookingRepository $booking,
                                LocatorRepository $locator,
                                ServiceRepository $service,
                                array $data = [])
    {
        $this->service = $service;
        $this->locator = $locator;
        $this->booking = $booking;
        parent::__construct($context, $data);
    }

    public function getBooking($bookingId)
    {
        $bookingCurrent = $this->booking->getById($bookingId);
        return $bookingCurrent;
    }

    public function getLocator($locatorId)
    {
        $locator = $this->locator->getById($locatorId);
        return $locator;
    }

    public function getService($serviceId)
    {
        $service = $this->service->getById($serviceId);
        return $service;
    }

    public function getAddressLocator($bookingId)
    {
        $booking = $this->getBooking($bookingId);
        $locator = $this->getLocator($booking->getLocatorId());
        $address = $locator->getData('address');
        return $address;
    }

    public function getPhoneLocator($bookingId)
    {
        $booking = $this->getBooking($bookingId);
        $locator = $this->getLocator($booking->getLocatorId());
        $phone = $locator->getData('phone');
        return $phone;
    }


    public function getEmailLocator($bookingId)
    {
        $booking = $this->getBooking($bookingId);
        $locator = $this->getLocator($booking->getLocatorId());
        $email = $locator->getData('email');
        return $email;
    }


    public function getName($bookingId)
    {
        $booking = $this->getBooking($bookingId);
        $name = $booking->getData("name");
        return $name;
    }

    public function getAddress($bookingId)
    {
        $booking = $this->getBooking($bookingId);
        $address = $booking->getData("address");
        return $address;
    }

    public function getPhone($bookingId)
    {
        $booking = $this->getBooking($bookingId);
        $phone = $booking->getData("phone");
        return $phone;
    }

    public function getNameService($bookingId)
    {
        $booking = $this->getBooking($bookingId);
        $service = $this->service->getById($booking->getServiceId());
        $name = $service->getData("name");
        return $name;
    }

    public function getCharge($bookingId)
    {
        $booking = $this->getBooking($bookingId);
        $charge = $booking->getData("charge");
        return $charge;
    }
}
