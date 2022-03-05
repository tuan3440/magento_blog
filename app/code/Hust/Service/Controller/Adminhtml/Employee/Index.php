<?php

namespace Hust\Service\Controller\Adminhtml\Employee;

use Hust\Service\Controller\Adminhtml\Employee;

class Index extends Employee
{
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Hust_Service::hust_employee');
        $resultPage->getConfig()->getTitle()->prepend(__('Employee'));
        $resultPage->addBreadcrumb(__('Employee'), __('Employee'));

        return $resultPage;
    }
}
