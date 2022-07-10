<?php

namespace Hust\Service\Model\ResourceModel\Voucher;

use Hust\Service\Model\Voucher;
use Hust\Service\Model\ResourceModel\Voucher as ResourceVoucher;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'voucher_id';

    protected function _construct()
    {
        $this->_init(Voucher::class, ResourceVoucher::class);
    }
}
