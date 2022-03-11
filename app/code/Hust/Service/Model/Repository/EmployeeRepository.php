<?php

namespace Hust\Service\Model\Repository;

use Hust\Service\Api\Data\EmployeeInterface;
use Hust\Service\Api\EmployeeRepositoryInterface;
use Hust\Service\Model\ResourceModel\Employee;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Hust\Service\Model\EmployeeFactory;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    private $employeeFactory;
    private $employeeResource;
    private $employees;

    public function __construct(
        EmployeeFactory $employeeFactory,
        Employee        $employeeResource
    )
    {
        $this->employeeFactory = $employeeFactory;
        $this->employeeResource = $employeeResource;
    }

    public function save(EmployeeInterface $employee)
    {
        try {
            if ($employee->getEmployeeId()) {
                $employee = $this->getById($employee->getEmployeeId())->addData($employee->getData());
            } else {
                $employee->getEmployeeId(null);
            }
            $this->employeeResource->save($employee);
            unset($this->employees[$employee->getEmployeeId()]);
        } catch (\Exception $e) {
            if ($employee->getEmployeeId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save employee with ID %1. Error: %2',
                        [$employee->getEmployeeId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new employee. Error: %1', $e->getMessage()));
        }
    }

    public function getById($employeeId)
    {
        if (!isset($this->employees[$employeeId])) {
            $employee = $this->employeeFactory->create();
            $this->employeeResource->load($employee, $employeeId);
            if (!$employee->getEmployeeId()) {
                throw new NoSuchEntityException(__('Employee with specified ID "%1" not found.', $employeeId));
            }
            $this->employees[$employeeId] = $employee;
        }
        return $this->employees[$employeeId];
    }

    public function delete(EmployeeInterface $employee)
    {
        try {
            $this->employeeResource->delete($employee);
            unset($this->employees[$employee->getEmployeeId()]);
        } catch (\Exception $e) {
            if ($employee->getEmployeeId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove employee with ID %1. Error: %2',
                        [$employee->getEmployeeId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(__('Unable to remove service. Error: %1', $e->getMessage()));
        }
        return true;
    }

    public function deleteById($employeeId)
    {
        $employeeModel = $this->getById($employeeId);
        $this->delete($employeeModel);

        return true;
    }

    public function getListEmployee()
    {
        $collection = $this->employeeFactory->create()->getCollection();
        return $collection;
    }
}
