<?php

namespace Hust\Service\Model\ResourceModel\Locator;

use Hust\Service\Model\ResourceModel\Locator as ResourceLocator;
use Hust\Service\Model\Locator;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'locator_id';

    protected function _construct()
    {
        $this->_init(Locator::class, ResourceLocator::class);
    }
}
