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
}
