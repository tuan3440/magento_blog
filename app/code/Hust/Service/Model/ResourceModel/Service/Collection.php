<?php

namespace Hust\Service\Model\ResourceModel\Service;

use Hust\Service\Model\ResourceModel\Service as ResourceService;
use Hust\Service\Model\Service;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'service_id';

    protected function _construct()
    {
        $this->_init(Service::class, ResourceService::class);
    }
}
