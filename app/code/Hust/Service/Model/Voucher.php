<?php

namespace Hust\Service\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Voucher extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'hust_booking_voucher';

    protected function _construct()
    {
        $this->_init('Hust\Service\Model\ResourceModel\Voucher');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
