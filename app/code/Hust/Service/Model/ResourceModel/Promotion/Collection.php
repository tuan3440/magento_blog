<?php

namespace Hust\Service\Model\ResourceModel\Promotion;

use Hust\Service\Model\ResourceModel\Promotion as ResourceService;
use Hust\Service\Model\ResourceModel\Promotion;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'promotion_id';

    protected function _construct()
    {
        $this->_init(Promotion::class, ResourceService::class);
    }
}
