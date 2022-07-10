<?php

namespace Hust\Service\Controller\Adminhtml\Voucher;

use Hust\Service\Controller\Adminhtml\Voucher;
use Magento\Framework\App\ResponseInterface;

class Index extends Voucher
{

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_voucher');
        $resultPage->getConfig()->getTitle()->prepend(__('Voucher'));
        $resultPage->addBreadcrumb(__('Voucher'), __('Voucher'));

        return $resultPage;
    }
}
