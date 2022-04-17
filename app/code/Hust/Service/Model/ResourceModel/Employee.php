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
        $select = $this->getConnection()->select()
            ->from(
                ['hust_employee' => $this->getTable('hust_employee')]
            )->joinLeft(
                ['hust_employee_locator' => $this->getTable('hust_employee_locator')],
                'hust_employee_locator.locator_id = '.$locatorId
            )->joinLeft(
                ['hust_employee_service' => $this->getTable('hust_employee_service')],
                'hust_employee_service.service_id = '.$serviceId
            );
//        echo $select->__toString();
//        die;
        $data = $this->getConnection()->fetchAll($select);
//        print_r($data);
//        die;
        return $data;
    }


}
