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

    public function joinTableRelation($table = '', $condition = '', $columns = [], $joinType = 'join')
    {
        if ($table && $condition) {
            $this->getSelect()->$joinType(
                ['tableAlias' => $this->getTable($table)],
                $condition,
                $columns
            );
        }

        return $this;
    }
}
