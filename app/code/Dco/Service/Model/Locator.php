<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Model;

use Dco\Service\Api\Data\LocatorInterface;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class Locator extends AbstractModel
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function __construct(
        Context $context,
        Registry $registry,
//        CountryFactory $countryFactory,
        ResourceModel\Locator $resource,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
//        $this->countryFactory = $countryFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Dco\Service\Model\ResourceModel\Locator');
    }

    /**
     * @param Locator $object
     * @return array
     */
    public function getServices(Locator $object)
    {
        $tbl = $this->_resource->getTable('spa_store_service_locator');
        $select = $this->_resource->getConnection()->select()->from(
            $tbl,
            ['service_id']
        )
            ->where(
                'locator_id = ?',
                (int) $object->getId()
            );
        return $this->_resource->getConnection()->fetchCol($select);
    }

    /**
     * @param Locator $object
     * @return array
     */
    public function getServicesWithPosition(Locator $object)
    {
        $tbl = $this->_resource->getTable('spa_store_service_locator');
        $select = $this->_resource->getConnection()->select()->from(
            $tbl,
            ['service_id']
        )
            ->where(
                'locator_id = ?',
                (int) $object->getId()
            );
        return $this->_resource->getConnection()->fetchAll($select);
    }

    /**
     * @param $serviceId
     * @return array
     */
    public function getLocatorInService($serviceId)
    {
        $tbl = $this->_resource->getTable('spa_store_service_locator');
        $select = $this->_resource->getConnection()->select()->from(
            $tbl,
            ['locator_id']
        )->where(
            'service_id = ?',
            (int) $serviceId
        )->group('locator_id');
        return $this->_resource->getConnection()->fetchCol($select);
    }


}
