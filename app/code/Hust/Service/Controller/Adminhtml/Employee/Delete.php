<?php

namespace Hust\Service\Controller\Adminhtml\Employee;

use Hust\Service\Controller\Adminhtml\Employee;
use Magento\Framework\App\ResponseInterface;

class Delete extends Employee
{
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = (int)$this->getRequest()->getParam('employee_id');
        if ($id) {
            try {
                $this->getEmployeeRepository()->deleteById($id);
                $this->getMessageManager()->addSuccessMessage(__('You deleted employee.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['employee_id' => $id]);
            }
        }
        $this->getMessageManager()->addErrorMessage(__('We can\'t find a employee to delete.'));

        return $resultRedirect->setPath('*/*/');    }
}
