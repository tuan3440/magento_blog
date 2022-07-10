<?php

namespace Hust\Service\Controller\Adminhtml\Voucher;

use Hust\Service\Controller\Adminhtml\Voucher;
use Magento\Framework\App\ResponseInterface;

class NewAction extends Voucher
{

    public function execute()
    {
        $this->initAction();
        $title = __("Add New Vouchers");

        $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
        $this->_view->renderLayout();
    }

    private function initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Hust_Service::hust_voucher')->_addBreadcrumb(
            __('Voucher'),
            __('Voucher')
        );
        return $this;
    }
}
