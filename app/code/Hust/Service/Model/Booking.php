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
        // TODO: Implement getBookingId() method.
    }

    public function setBookingId($id)
    {
        // TODO: Implement setBookingId() method.
    }

    public function getLocatorId()
    {
        // TODO: Implement getLocatorId() method.
    }

    public function setLocatorId($locatorId)
    {
        // TODO: Implement setLocatorId() method.
    }

    public function getServiceId()
    {
        // TODO: Implement getServiceId() method.
    }

    public function setServiceId($serviceId)
    {
        // TODO: Implement setServiceId() method.
    }

    public function getCustomerId()
    {
        // TODO: Implement getCustomerId() method.
    }

    public function setCustomerId($customerId)
    {
        // TODO: Implement setCustomerId() method.
    }

    public function getBookingStatus()
    {
        // TODO: Implement getBookingStatus() method.
    }

    public function setBookingStatus($status)
    {
        // TODO: Implement setBookingStatus() method.
    }

    public function getHourBooking()
    {
        // TODO: Implement getHourBooking() method.
    }

    public function setHourBooking($hourBooking)
    {
        // TODO: Implement setHourBooking() method.
    }

    public function getDateBooking()
    {
        // TODO: Implement getDateBooking() method.
    }

    public function setDateBooking($dateBooking)
    {
        // TODO: Implement setDateBooking() method.
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
