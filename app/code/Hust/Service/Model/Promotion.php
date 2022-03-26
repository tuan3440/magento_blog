<?php

namespace Hust\Service\Model;

use Hust\Service\Api\Data\PromotionInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;

class Promotion extends AbstractModel implements IdentityInterface, PromotionInterface
{
    const CACHE_TAG = 'hust_booking_promotion';

    public function __construct(Context $context, \Magento\Framework\Registry $registry, ResourceModel\Promotion $resource, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [])
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Hust\Service\Model\ResourceModel\Promotion');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getPromotionId()
    {
        return $this->getData(PromotionInterface::PROMOTION_ID);
    }

    public function setPromotionId($promotionId)
    {
        // TODO: Implement setPromotionId() method.
    }

    public function getImage()
    {
        return $this->getData(PromotionInterface::IMAGE);
    }

    public function setImage($image)
    {
        // TODO: Implement setImage() method.
    }

    public function getDescription()
    {
        // TODO: Implement getDescription() method.
    }

    public function setDescription($description)
    {
        // TODO: Implement setDescription() method.
    }

    public function getRule()
    {
        // TODO: Implement getRule() method.
    }

    public function setRule($rule)
    {
        // TODO: Implement setRule() method.
    }

    public function getStatus()
    {
        // TODO: Implement getStatus() method.
    }

    public function setStatus($status)
    {
        // TODO: Implement setStatus() method.
    }

    public function getDateStart()
    {
        // TODO: Implement getDateStart() method.
    }

    public function setDateStart($date)
    {
        // TODO: Implement setDateStart() method.
    }

    public function getDateEnd()
    {
        // TODO: Implement getDateEnd() method.
    }

    public function setDateEnd($date)
    {
        // TODO: Implement setDateEnd() method.
    }

    public function getName()
    {
        return $this->getData(PromotionInterface::NAME);
    }

    public function setName($name)
    {
        // TODO: Implement setName() method.
    }

    public function getServiceId()
    {
        // TODO: Implement getServiceId() method.
    }

    public function setServiceId($serviceIds)
    {
        // TODO: Implement setServiceId() method.
    }
}
