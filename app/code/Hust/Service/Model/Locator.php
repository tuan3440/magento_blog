<?php

namespace Hust\Service\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Hust\Service\Api\Data\LocatorInterface;
use Magento\Framework\Model\Context;

class Locator extends AbstractModel implements IdentityInterface, LocatorInterface
{
    const CACHE_TAG = 'hust_locator';

    protected function _construct()
    {
        $this->_init('Hust\Service\Model\ResourceModel\Locator');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getLocatorId()
    {
        return $this->getData(LocatorInterface::LOCATOR_ID);

    }

    public function setLocatorId($locatorId)
    {
        $this->setData(LocatorInterface::LOCATOR_ID, $locatorId);
        return $this;
    }

    public function getName()
    {
        return $this->getData(LocatorInterface::NAME);
    }

    public function setName($name)
    {
        $this->setData(LocatorInterface::NAME, $name);
        return $this;
    }

    public function getCode()
    {
        return $this->getData(LocatorInterface::CODE);
    }

    public function setCode($code)
    {
        $this->setData(LocatorInterface::CODE, $code);
        return $this;
    }

    public function getAddress()
    {
        return $this->getData(LocatorInterface::ADDRESS);
    }

    public function setAddress($address)
    {
        $this->setData(LocatorInterface::ADDRESS, $address);
        return $this;
    }

    public function getCity()
    {
        return $this->getData(LocatorInterface::CITY);
    }

    public function setCity($city)
    {
        $this->setData(LocatorInterface::CITY, $city);
        return $this;
    }

    public function getCountry()
    {
        return $this->getData(LocatorInterface::COUNTRY);
    }

    public function setCountry($country)
    {
        $this->setData(LocatorInterface::COUNTRY, $country);
        return $this;
    }

    public function getPhone()
    {
        return $this->getData(LocatorInterface::PHONE);
    }

    public function setPhone($phone)
    {
        $this->setData(LocatorInterface::PHONE, $phone);
        return $this;
    }

    public function getEmail()
    {
        return $this->getData(LocatorInterface::EMAIL);
    }

    public function setEmail($email)
    {
        $this->setData(LocatorInterface::EMAIL, $email);
        return $this;
    }

    public function getIsActive()
    {
        return $this->getData(LocatorInterface::IS_ACTIVE);
    }

    public function setIsActive($isActive)
    {
        $this->setData(LocatorInterface::IS_ACTIVE, $isActive);
        return $this;
    }

    public function getServicesWithPosition(\Hust\Service\Model\Locator $object)
    {
        $tbl = $this->_resource->getTable('hust_service_locator');
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
}
