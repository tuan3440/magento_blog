<?php

namespace Hust\Service\Controller\Adminhtml\Promotion;

use Hust\Service\Controller\Adminhtml\Promotion;
use Magento\Framework\App\ResponseInterface;

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
