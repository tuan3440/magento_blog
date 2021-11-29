<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Controller\Adminhtml\Locator;

use Dco\Service\Controller\Adminhtml\Locator;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Locator
{
    /**
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Dco_Service::service_locator');
        $resultPage->addBreadcrumb(__('Locator'), __('Locator'));
        $resultPage->addBreadcrumb(__('Locator Management'), __('Locator Management'));
        $resultPage->getConfig()->getTitle()->prepend(__('Locator Management'));

        return $resultPage;
    }
}
