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

    public function getServiceSlot()
    {
        $this->getSelect()->where("main_table.is_active=1");
        return $this;
    }

    public function joinTableRelation($table = '', $condition = '', $columns = [], $joinType = 'join')
    {
        if ($table && $condition) {
            $this->getSelect()->distinct(true)->$joinType(
                ['tableAlias' => $this->getTable($table)],
                $condition,
                $columns
            );
        }
        return $this;
    }

    public function getNumberSlot($locatorId, $serviceId)
    {
        $select = "SELECT hust_service_locator.slot FROM hust_service_locator WHERE hust_service_locator.service_id=".$serviceId." AND hust_service_locator.locator_id=".$locatorId;
        $result = $this->getConnection()->fetchOne($select);
        return $result;
    }
}
