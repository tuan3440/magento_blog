<?php

namespace Hust\Service\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class BookingSale extends AbstractDb
{
    const TABLE_NAME = 'hust_booking_sale';

    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'id');
    }

    public function getListPhone($serviceId)
    {
        $phones = $this->getConnection()->fetchAll("
          SELECT phone FROM hust_booking_sale where service_id = ".$serviceId
        );

        return $phones;
    }
}
