<?php

namespace Hust\Service\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Hust\Service\Api\Data\LocatorInterface;

class Locator extends AbstractModel implements IdentityInterface, LocatorInterface
{
    const CACHE_TAG = 'hust_locator';
    protected function __construct()
    {
        $this->_init('Hust\Service\Model\ResourceModel\Locator');
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getLocatorId()
    {
        // TODO: Implement getLocatorId() method.
    }

    public function setLocatorId($locatorId)
    {
        // TODO: Implement setLocatorId() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function setName($name)
    {
        // TODO: Implement setName() method.
    }

    public function getCode()
    {
        // TODO: Implement getCode() method.
    }

    public function setCode($code)
    {
        // TODO: Implement setCode() method.
    }

    public function getAddress()
    {
        // TODO: Implement getAddress() method.
    }

    public function setAddress($address)
    {
        // TODO: Implement setAddress() method.
    }

    public function getCity()
    {
        // TODO: Implement getCity() method.
    }

    public function setCity($city)
    {
        // TODO: Implement setCity() method.
    }

    public function getCountry()
    {
        // TODO: Implement getCountry() method.
    }

    public function setCountry($country)
    {
        // TODO: Implement setCountry() method.
    }

    public function getPhone()
    {
        // TODO: Implement getPhone() method.
    }

    public function setPhone($phone)
    {
        // TODO: Implement setPhone() method.
    }

    public function getEmail()
    {
        // TODO: Implement getEmail() method.
    }

    public function setEmail($email)
    {
        // TODO: Implement setEmail() method.
    }

    public function getIsActive()
    {
        // TODO: Implement getIsActive() method.
    }

    public function setIsActive($isActive)
    {
        // TODO: Implement setIsActive() method.
    }
}
