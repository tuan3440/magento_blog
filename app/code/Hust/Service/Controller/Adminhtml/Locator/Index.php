<?php

namespace Hust\Service\Controller\Adminhtml\Locator;

use Hust\Service\Controller\Adminhtml\Locator;
use Magento\Framework\App\ResponseInterface;

class Index extends Locator
{
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_locator');
        $resultPage->getConfig()->getTitle()->prepend(__('Locator'));
        $resultPage->addBreadcrumb(__('Locator'), __('Locator'));

        return $resultPage;
    }
}
