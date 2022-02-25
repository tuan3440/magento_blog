<?php

namespace Hust\Service\Controller\Adminhtml\Service;

use Hust\Service\Controller\Adminhtml\Service;
use Magento\Framework\App\ResponseInterface;

class Index extends Service
{
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_service');
        $resultPage->getConfig()->getTitle()->prepend(__('Service'));
        $resultPage->addBreadcrumb(__('Service'), __('Service'));

        return $resultPage;
    }
}
