<?php

namespace Hust\Service\Api\Data;

interface PromotionInterface
{
    const PROMOTION_ID = 'promotion_id';
    const NAME = 'name';
    const IMAGE = 'image';
    const DESCRIPTION = 'description';
    const RULE = 'rule';
    const SERVICE_ID = 'service_ids';
    const STATUS = 'status';
    const DATE_START = 'date_start';
    const DATE_END = 'date_end';

    public function getPromotionId();
    public function setPromotionId($promotionId);
    public function getName();
    public function setName($name);
    public function getImage();
    public function setImage($image);
    public function getDescription();
    public function setDescription($description);
    public function getRule();
    public function setRule($rule);
    public function getStatus();
    public function setStatus($status);
    public function getServiceId();
    public function setServiceId($serviceIds);
    public function getDateStart();
    public function setDateStart($date);
    public function getDateEnd();
    public function setDateEnd($date);
}
