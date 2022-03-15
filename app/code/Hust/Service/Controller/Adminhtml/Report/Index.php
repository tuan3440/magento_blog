<?php

namespace Hust\Service\Controller\Adminhtml\Report;

use Magento\Framework\App\ResponseInterface;
use Magento\Reports\Controller\Adminhtml\Report\AbstractReport;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

class Index extends AbstractReport implements HttpGetActionInterface
{

    public function execute()
    {
        $this->_initAction()->_setActiveMenu(
            'Hust_Service::hust_report'
        )->_addBreadcrumb(
            __('Booking Report'),
            __('Booking Report')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Booking Report'));

        $gridBlock = $this->_view->getLayout()->getBlock('adminhtml_report.grid');
        $filterFormBlock = $this->_view->getLayout()->getBlock('grid.filter.form');

        $this->_initReportAction([$filterFormBlock, $gridBlock]);

        $this->_view->renderLayout();
    }
}
