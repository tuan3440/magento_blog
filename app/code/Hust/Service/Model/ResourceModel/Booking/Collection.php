<?php

namespace Hust\Service\Model\ResourceModel\Booking;

use Hust\Service\Model\ResourceModel\Booking as ResourceBooking;
use Hust\Service\Model\Booking;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'booking_id';

    protected function _construct()
    {
        $this->_init(Booking::class, ResourceBooking::class);
    }
}
