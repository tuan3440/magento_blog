<?php

namespace Hust\Service\Controller\Promotion;

use Hust\Service\Model\Repository\PromotionRepository;
use Hust\Service\Model\ServiceRegistry;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Hust\Service\Controller\Index
{

    private $registry;
    private $promotionRepository;
    public function __construct(Context $context,
                                PageFactory $resultPageFactory,
                                ServiceRegistry $registry,
                                PromotionRepository $promotionRepository
    )
    {
        $this->registry = $registry;
        $this->promotionRepository = $promotionRepository;
        parent::__construct($context, $resultPageFactory);
    }

    public function execute()
    {
        $promotionId = $this->getRequest()->getParam('promotion_id');
        $currentPromotion = $this->promotionRepository->getById($promotionId);
        $this->registry->register('current_promotion', $currentPromotion);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Promotion'));

        return $resultPage;
    }
}
