<?php

namespace Hust\Service\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Employee extends AbstractDb
{
    const TABLE_NAME = 'hust_employee';

    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'employee_id');
    }

    public function getEmployeeOfLocatorAndService($locatorId, $serviceId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sql = "SELECT DISTINCT hust_employee_locator.employee_id FROM hust_employee_locator, hust_employee_service
WHERE hust_employee_locator.locator_id = " . $locatorId . " AND hust_employee_service.service_id = " . $serviceId;
        $result = $connection->fetchAll($sql);
        if ($result) {
            $employeeIds = [];
            foreach ($result as $r) {
                $employeeIds[] = $r['employee_id'];
            }
            $employeeIdsString = implode(',', $employeeIds);

            $sql = "SELECT * FROM hust_employee WHERE employee_id IN (".$employeeIdsString.")";
            $result2 = $connection->fetchAll($sql);
            return $result2;
        }

        return null;
    }

    public function checkEmployee($employeeId, $locatorId)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sql = "SELECT  hust_employee.employee_id FROM hust_employee_locator, hust_employee
WHERE hust_employee_locator.locator_id = " . $locatorId . " AND hust_employee.employee_id = " . $employeeId;
        $result = $connection->fetchAll($sql);
        return $result;

    }
}
