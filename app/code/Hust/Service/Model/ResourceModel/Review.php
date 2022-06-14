<?php

namespace Hust\Service\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Zend_Db_Expr;
use Zend_Db_Select;
class Review extends AbstractDb
{
    const TABLE_NAME = 'hust_booking_review';

    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'review_id');
    }

    public function getPointService($serviceId)
    {
        $select = $this->getConnection()->select()->from(['main_table' => $this->getTable('hust_booking_review')])
            ->where('main_table.service_id = '.$serviceId)
            ->reset(Zend_Db_Select::COLUMNS)->columns([
                "avg" => new Zend_Db_Expr('AVG(main_table.point)')
            ]);
        $point = $this->getConnection()->fetchAll($select);

        return $point;
    }

}
