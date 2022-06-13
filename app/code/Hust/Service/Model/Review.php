<?php

namespace Hust\Service\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Review extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'hust_booking_review';

    protected function _construct()
    {
        $this->_init('Hust\Service\Model\ResourceModel\Review');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
