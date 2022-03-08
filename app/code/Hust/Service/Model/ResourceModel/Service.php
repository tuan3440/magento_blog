<?php

namespace Hust\Service\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Service extends AbstractDb
{
    const TABLE_NAME = 'hust_service';

    public function __construct(Context $context, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'service_id');
    }

    public function getRelatedProduct($serviceId)
    {
        $sql = $this->getConnection()->select()
            ->from(
                'hust_service_products'
            )->where('hust_service_products.service_id = ?', $serviceId);
        $productIds = $this->getConnection()->fetchAll($sql);
        return $productIds;
    }
}
