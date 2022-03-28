<?php

namespace Hust\Service\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Promotion extends AbstractDb
{
    const TABLE_NAME = 'hust_booking_promotion';

    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'promotion_id');
    }

    public function getPromotionByServiceId($serviceId)
    {
        $select = $this->getConnection()->select()->from(['main_table' => $this->getTable('hust_booking_promotion')])
            ->where('main_table.service_id LIKE ?', '%'.$serviceId.'%')->where('date_start < NOW()')->where('date_end > NOW()');
        $promotions = $this->getConnection()->fetchAll($select);

        return $promotions;
    }

    public function getDiscountByPromotion($serviceId)
    {
        $promotion = $this->getPromotionByServiceId($serviceId);
        $discount = 0;
        foreach ($promotion as $p) {
            if (((int)$p['rule']*0.01) > $discount ) {
                $discount = (int)$p['rule']*0.01;
            }
        }
        return (1 - $discount);
    }
}
