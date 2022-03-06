<?php

namespace Hust\Service\Model\ResourceModel\Employee;

use Hust\Service\Model\Employee;
use Hust\Service\Model\ResourceModel\Employee as ResourceLocator;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'employee_id';

    protected function _construct()
    {
        $this->_init(Employee::class, ResourceLocator::class);
    }
}
