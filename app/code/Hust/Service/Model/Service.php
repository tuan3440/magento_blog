<?php

namespace Hust\Service\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Hust\Service\Api\Data\ServiceInterface;

class Service extends AbstractModel implements IdentityInterface, ServiceInterface
{
    const CACHE_TAG = 'hust_service';
    protected function _construct()
    {
        $this->_init('Hust\Service\Model\ResourceModel\Service');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getServiceId()
    {
        return $this->getData(ServiceInterface::SERVICE_ID);
    }

    public function setServiceId($serviceId)
    {
        $this->setData(ServiceInterface::SERVICE_ID, $serviceId);
        return $this;
    }

    public function getName()
    {
       return $this->getData(ServiceInterface::NAME);
    }

    public function setName($name)
    {
        $this->getData(ServiceInterface::NAME, $name);
        return $this;
    }

    public function getImage()
    {
        return $this->getData(ServiceInterface::IMAGE);
    }

    public function setImage($image)
    {
        $this->setData(ServiceInterface::IMAGE, $image);
        return $this;
    }

    public function getShortDescription()
    {
        return $this->getData(ServiceInterface::SHORT_DESCRIPTION);
    }

    public function setShortDescription($shortDescription)
    {
        $this->setData(ServiceInterface::SHORT_DESCRIPTION, $shortDescription);
        return $this;
    }

    public function getContent()
    {
        return $this->getData(ServiceInterface::CONTENT);
    }

    public function setContent($content)
    {
        $this->setData(ServiceInterface::CONTENT, $content);
        return $this;
    }

    public function getCharge()
    {
        return $this->getData(ServiceInterface::CHARGE);
    }

    public function setCharge($price)
    {
        $this->setData(ServiceInterface::CHARGE, $price);
        return $this;
    }

    public function getIsActive()
    {
        return $this->getData(ServiceInterface::IS_ACTIVE);
    }

    public function setIsActive($isActive)
    {
        $this->setData(ServiceInterface::IS_ACTIVE, $isActive);
        return $this;
    }

    public function getPosition()
    {
        return $this->getData(ServiceInterface::POSITION);
    }

    public function setPosition($position)
    {
        $this->setData(ServiceInterface::POSITION, $position);
        return $this;
    }
}
