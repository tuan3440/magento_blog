<?php

namespace Hust\Service\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Zend_Db_Expr;
use Zend_Db_Select;
class Booking extends AbstractDb
{
    const TABLE_NAME = 'hust_booking';

    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'booking_id');
    }

    public function getEmployeeBooking($bookingId)
    {
        $sql = $this->getConnection()->select()
            ->from(
                'hust_booking_employee'
            )->where('hust_booking_employee.booking_id = ?', $bookingId);
        $employeeId = $this->getConnection()->fetchOne($sql);
        return $employeeId;
    }

    public function getEmployeeNotAvailable($locatorId, $serviceId, $booking_hour, $date)
    {
        $select = $this->getConnection()->select()
            ->from(
                ['hust_booking' => $this->getTable('hust_booking')]
            )->joinLeft(
                ['hust_booking_employee' => $this->getTable('hust_booking_employee')],
                'hust_booking.booking_id = hust_booking_employee.booking_id',
                ['hust_booking_employee.employee_id']
            )->where(
                'hust_booking.locator_id = '.$locatorId
            )->where(
                'hust_booking.booking_hour = '.$booking_hour
            )->where(
                "hust_booking.date = '".$date."'"
            )->where(
                'hust_booking.booking_status = 1'
            );
        $result = [];
        $data = $this->getConnection()->fetchAll($select);
        foreach ($data as $x) {
            $result[] = $x['employee_id'];
        }
        return $result;
    }

    public function getEmployeesByDate($locatorId, $serviceId, $date)
    {
        $select = $this->getConnection()->select()
            ->from(
                ['hust_booking' => $this->getTable('hust_booking')]
            )->joinLeft(
                ['hust_booking_employee' => $this->getTable('hust_booking_employee')],
                'hust_booking.booking_id = hust_booking_employee.booking_id',
                ['hust_booking_employee.employee_id']
            )->reset(Zend_Db_Select::COLUMNS)
            ->columns([
                'employee_id' => 'hust_booking_employee.employee_id',
                'count' => new Zend_Db_Expr('count(*)')
            ])
            ->where(
                'hust_booking.locator_id = '.$locatorId
            )
            ->where(
                "hust_booking.date = '".$date."'"
            )->where(
                'hust_booking.booking_status = 1'
            )->group('employee_id')
            ->order('count asc');
        $data = $this->getConnection()->fetchAll($select);
        return $data;
    }


}
