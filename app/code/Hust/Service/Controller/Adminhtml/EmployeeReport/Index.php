<?php

namespace Hust\Service\Controller\Adminhtml\EmployeeReport;

use Hust\Service\Controller\Adminhtml\EmployeeReport;

class Index extends EmployeeReport
{
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_employee_report');
        $resultPage->getConfig()->getTitle()->prepend(__('Employee Report'));
        $resultPage->addBreadcrumb(__('Employee Report'), __('Employee Report'));

        return $resultPage;
    }
}
