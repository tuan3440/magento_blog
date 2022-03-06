<?php

namespace Hust\Service\Controller\Adminhtml\Employee;

use Hust\Service\Controller\Adminhtml\Employee;
use Magento\Framework\App\ResponseInterface;

class Edit extends Employee
{

    const CURRENT_EMPLOYEE = 'current_employee';

    public function execute()
    {
        $employeeId = $this->getRequest()->getParam('employee_id');
        $model = $this->getEmployeeFactory()->create();
        if ($employeeId) {
            try {
                $model = $this->getEmployeeRepository()->getById($employeeId);
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage($e->getMessage());
                $this->_redirect('*/*');

                return;
            }
        }

        $this->getServiceRegistry()->register(self::CURRENT_EMPLOYEE, $model);
        $this->initAction();
        $title = $model->getId() ? __('Edit Employee `%1`', $model->getName()) : __("Add New Employee");

        $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
        $this->_view->renderLayout();
    }

    private function initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Hust_Service::hust_service')->_addBreadcrumb(
            __('Employee'),
            __('Employee')
        );
        return $this;
    }
}
