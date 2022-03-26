<?php

namespace Hust\Service\Api;

interface PromotionRepositoryInterface
{
    public function save(\Hust\Service\Api\Data\PromotionInterface $promotion);
    public function getById($promotionId);
    public function delete(\Hust\Service\Api\Data\PromotionInterface $promotion);
    public function deleteById($promotionId);
}
