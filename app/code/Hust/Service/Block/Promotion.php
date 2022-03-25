<?php

namespace Hust\Service\Block;

use Magento\Framework\View\Element\Template;
use Hust\Service\Model\ServiceRegistry;
use Hust\Service\Model\Repository\PromotionRepository;

class Promotion extends Template
{
    protected $registry;
    protected $promotionRepo;
    public function __construct(
        ServiceRegistry $registry,
        PromotionRepository $promotionRepository,
        Template\Context $context, array $data = [])
    {
        $this->registry = $registry;
        $this->promotionRepo = $promotionRepository;
        parent::__construct($context, $data);
    }

    public function getPromotion()
    {
        return $this->registry->registry('current_promotion');
    }

    public function getAllPromotion()
    {
        $promotions = $this->promotionRepo->getListPromotion();
        return $promotions;
    }
}
