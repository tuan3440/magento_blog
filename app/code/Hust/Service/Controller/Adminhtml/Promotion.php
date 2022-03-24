<?php

namespace Hust\Service\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Hust\Service\Model\PromotionFactory;
use Hust\Service\Model\Repository\PromotionRepository;
use Hust\Service\Model\ServiceRegistry;

abstract class Promotion extends Action
{
    const ADMIN_RESOURCE = 'Hust_Service::hust_promotion';
    protected $resultPageFactory;
    protected $promotionFactory;
    protected $promotionRepository;
    protected $serviceRegister;

    public function __construct(
        PageFactory $pageFactory,
        PromotionFactory $promotionFactory,
        PromotionRepository $promotionRepository,
        ServiceRegistry $serviceRegistry,
        Context $context
    )
    {
        $this->resultPageFactory = $pageFactory;
        $this->promotionFactory = $promotionFactory;
        $this->promotionRepository = $promotionRepository;
        $this->serviceRegister = $serviceRegistry;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }

    protected function getPromotionFactory()
    {
        return $this->promotionFactory;
    }

    protected function getPromotionRepository()
    {
        return $this->promotionRepository;
    }

    protected function getServiceRegistry()
    {
        return $this->serviceRegister;
    }
}
