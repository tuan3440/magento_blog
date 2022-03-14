<?php

namespace Hust\Service\Ui\Component\Form\Employee;
use Magento\Framework\Data\OptionSourceInterface;
use Hust\Service\Model\Repository\EmployeeRepository;

class ListEmployee implements OptionSourceInterface
{
    private $employeeRepository;

    public function __construct(
        EmployeeRepository $employeeRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function toOptionArray()
    {
        $employees = $this->employeeRepository->getListEmployee();
        $data = [];
        if ($employees) {
            foreach ($employees as $employee) {
                $data[] = ['value' => $employee->getEmployeeId(), 'label' => $employee->getFirstName().' '.$employee->getLastName()];
            }
        }
        return $data;
    }

    public function toArray()
    {
        $employees = $this->employeeRepository->getListEmployee();
        $data = [];
        if ($employees) {
            foreach ($employees as $employee) {
                $data[] = [$employee->getEmployeeId() => $employee->getFirstName().' '.$employee->getLastName()];
            }
        }
        return $data;
    }
}


