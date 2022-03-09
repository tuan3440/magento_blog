<?php

namespace Hust\Service\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Hust\Service\Api\Data\BookingInterface;

class Booking extends AbstractModel implements IdentityInterface, BookingInterface
{
    const CACHE_TAG = 'hust_booking';
    protected function _construct()
    {
        $this->_init('Hust\Service\Model\ResourceModel\Booking');
    }
    public function getBookingId()
    {
        return $this->getData(BookingInterface::BOOKING_ID);
    }

    public function setBookingId($id)
    {
        $this->setData(BookingInterface::BOOKING_ID, $id);
        return $this;
    }

    public function getLocatorId()
    {
        return $this->getData(BookingInterface::LOCATOR_ID);
    }

    public function setLocatorId($locatorId)
    {
        $this->setData(BookingInterface::LOCATOR_ID, $locatorId);
        return $this;
    }

    public function getServiceId()
    {
        return $this->getData(BookingInterface::SERVICE_ID);
    }

    public function setServiceId($serviceId)
    {
        $this->setData(BookingInterface::SERVICE_ID, $serviceId);
        return $this;
    }

    public function getBookingStatus()
    {
        return $this->getData(BookingInterface::BOOKING_STATUS);
    }

    public function setBookingStatus($status)
    {
        $this->setData(BookingInterface::BOOKING_STATUS, $status);
        return $this;
    }

    public function getHourBooking()
    {
        return $this->getData(BookingInterface::HOUR_BOOKING);
    }

    public function setHourBooking($hourBooking)
    {
        $this->setData(BookingInterface::HOUR_BOOKING, $hourBooking);
        return $this;
    }

    public function getDateBooking()
    {
        return $this->getData(BookingInterface::DATE_BOOKING);
    }

    public function setDateBooking($dateBooking)
    {
        $this->setData(BookingInterface::DATE_BOOKING, $dateBooking);
        return $this;
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getName()
    {
        return $this->getData(BookingInterface::NAME);
    }

    public function setName($name)
    {
        $this->setData(BookingInterface::NAME, $name);
        return $this;
    }

    public function getAge()
    {
        return $this->getData(BookingInterface::AGE);
    }

    public function setAge($age)
    {
        $this->setData(BookingInterface::AGE, $age);
        return $this;
    }

    public function getGender()
    {
        return $this->getData(BookingInterface::GENDER);
    }

    public function setGender($gender)
    {
        $this->setData(BookingInterface::GENDER, $gender);
        return $this;
    }

    public function getPhone()
    {
        return $this->getData(BookingInterface::PHONE);
    }

    public function setPhone($phone)
    {
        $this->setData(BookingInterface::PHONE, $phone);
        return $this;
    }

    public function getEmail()
    {
        return $this->getData(BookingInterface::EMAIL);
    }

    public function setEmail($email)
    {
        $this->setData(BookingInterface::EMAIL, $email);
        return $this;
    }

    public function getAddress()
    {
        return $this->getData(BookingInterface::ADDRESS);
    }

    public function setAddress($address)
    {
        $this->setData(BookingInterface::ADDRESS, $address);
        return $this;
    }
}
