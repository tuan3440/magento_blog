<?php

namespace Hust\Service\Controller\Adminhtml\Promotion;

use Hust\Service\Controller\Adminhtml\Promotion;
use Hust\Service\Model\PromotionFactory;
use Hust\Service\Model\Repository\PromotionRepository;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Promotion
{

    protected $resultFactory;

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_promotion');
        $resultPage->getConfig()->getTitle()->prepend(__('Promotion'));
        $resultPage->addBreadcrumb(__('Promotion'), __('Promotion'));

        return $resultPage;
    }
}
