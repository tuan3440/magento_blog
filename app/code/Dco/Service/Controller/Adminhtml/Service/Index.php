<?php

namespace Dco\Service\Controller\Adminhtml\Service;

use Dco\Service\Controller\Adminhtml\Service;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Index extends Service
{
    /**
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Dco_Service::service');
        $resultPage->addBreadcrumb(__('Service'), __('Service'));
        $resultPage->addBreadcrumb(__('Service Management'), __('Service Management'));
        $resultPage->getConfig()->getTitle()->prepend(__('Service Management'));

        return $resultPage;
    }
}
