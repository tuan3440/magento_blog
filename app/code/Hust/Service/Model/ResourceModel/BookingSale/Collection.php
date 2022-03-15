<?php

namespace Hust\Service\Model\ResourceModel\BookingSale;

use Hust\Service\Model\BookingSale;
use Hust\Service\Model\ResourceModel\BookingSale as ResourceBooking;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(BookingSale::class, ResourceBooking::class);
    }
}
