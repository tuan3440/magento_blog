<?php

namespace Hust\Service\Api\Data;

interface ServiceInterface
{
    const SERVICE_ID = 'service_id';
    const NAME = 'name';
    const IMAGE = 'image';
    const SHORT_DESCRIPTION = 'short_description';
    const CONTENT = 'content';
    const PRICE_SERVICE = 'price_service';
    const IS_ACTIVE = 'is_active';
    const POSITION = 'position';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function getServiceId();
    public function setServiceId($serviceId);
    public function getName();
    public function setName($name);
    public function getImage();
    public function setImage($image);
    public function getShortDescription();
    public function setShortDescription($shortDescription);
    public function getContent();
    public function setContent($content);
    public function getPriceService();
    public function setPriceService($price);
    public function getIsActive();
    public function setIsActive($isActive);
    public function getPosition();
    public function setPosition($position);
}
