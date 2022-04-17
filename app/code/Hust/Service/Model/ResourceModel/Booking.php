<?php

namespace Hust\Service\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

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
                'hust_booking.booking_id = hust_booking_employee.booking_id'
            )->where(
                'hust_booking.locator_id = '.$locatorId
            )->where(
                'hust_booking.service_id = '.$serviceId
            )->where(
                'hust_booking.booking_hour = '.$booking_hour
            )->where(
                "hust_booking.date = '".$date."'"
            )->where(
                'hust_booking.booking_status = 1'
            );
//        echo $select->__toString();
//        die;
        $data = $this->getConnection()->fetchCol($select, ['employee_id']);
        return $data;
    }
}
