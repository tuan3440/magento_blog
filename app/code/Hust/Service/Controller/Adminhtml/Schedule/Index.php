<?php

namespace Hust\Service\Controller\Adminhtml\Schedule;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Reports\Controller\Adminhtml\Report\AbstractReport;

class Index extends AbstractReport implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Hust_Service::hust_schedule';

    public function execute()
    {
        $this->_initAction()->_setActiveMenu(
            'Hust_Service::hust_schedule'
        )->_addBreadcrumb(
            __('Booking Schedule'),
            __('Booking Schedule')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Booking Schedule'));

        $gridBlock = $this->_view->getLayout()->getBlock('adminhtml_schedule.grid');
        $filterFormBlock = $this->_view->getLayout()->getBlock('grid.filter.form');

        $this->_initReportAction([$filterFormBlock, $gridBlock]);

        $this->_view->renderLayout();
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}

