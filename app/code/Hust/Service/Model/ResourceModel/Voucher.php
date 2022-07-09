<?php

namespace Hust\Service\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Voucher extends AbstractDb
{
    const TABLE_NAME = 'hust_booking_voucher';

    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'voucher_id');
    }

    public function checkVoucherCode($code)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $sql = "SELECT * FROM hust_booking_voucher WHERE voucher_code =".$code. " AND date_end > NOW()";
        $result2 = $connection->fetchAll($sql);
        return $result2;
    }
}
