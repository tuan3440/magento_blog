<?php

namespace Hust\Service\Block;

use Magento\Framework\View\Element\Template;
use Hust\Service\Model\ServiceRegistry;

class Promotion extends Template
{
    protected $registry;
    public function __construct(
        ServiceRegistry $registry,
        Template\Context $context, array $data = [])
    {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getPromotion()
    {
        return $this->registry->registry('current_promotion');
    }
}
