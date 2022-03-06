<?php

namespace Hust\Service\Controller\Adminhtml\Employee;

use Hust\Service\Controller\Adminhtml\Employee;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Employee
{
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            $employeeId = (int)$this->getRequest()->getParam('employee_id');
            try {
                if ($employeeId) {
                    $model = $this->getEmployeeRepository()->getById($employeeId);
                } else {
                    $model = $this->getEmployeeFactory()->create();
                }
                $data = $this->prepareData($data);
                $model->addData($data);
                $this->getEmployeeRepository()->save($model);
                $this->saveServiceEmployee($model);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['employee_id' => $model->getId()]);
                    return;
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                if ($employeeId = (int)$this->getRequest()->getParam('employee_id')) {
                    $this->_redirect('*/*/edit', ['employee_id' => $employeeId]);
                } else {
                    $this->_redirect('*/*/');
                }
                return;
            }
            $this->_redirect('*/*/');
        }
    }

    private function prepareData(array $data)
    {
        if (isset($data['image']) && is_array(($data['image']))) {
            if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                $data['image'] = $data['image'][0]['file'];
            } else {
                $data['image'] = $data['image'][0]['name'];
            }
        }
        return $data;
    }

    private function saveServiceEmployee($model)
    {
        try {
            $newServices = $model['service_id'];
            $this->_resources = ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
            $connection = $this->_resources->getConnection();

            $table = $this->_resources->getTableName('hust_employee_service');
            $where = [
                'employee_id = ?' => (int)$model->getId()
            ];
            $connection->delete($table, $where);

            if ($newServices) {
                if (!is_array($newServices)) $newServices = explode(',', $newServices);
                $data = [];
                foreach ($newServices as $service_id) {
                    $data[] = [
                        'service_id' => $service_id,
                        'employee_id' => $model->getId(),
                    ];
                }
                $connection->insertMultiple($table, $data);
            }
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the services.'));
        }
    }
}
