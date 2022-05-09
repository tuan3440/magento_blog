<?php

namespace Hust\Service\Block\Adminhtml\Grid\Columns\Renderer;

use Hust\Service\Model\Repository\EmployeeRepository;
use Magento\Backend\Block\Context;
use Magento\Framework\DataObject;

class Employee extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $employee;
    public function __construct(Context $context,
                                EmployeeRepository $employeeRepository,
                                array $data = [])
    {
        $this->employee = $employeeRepository;
        parent::__construct($context, $data);
    }

    public function render(DataObject $row)
    {
        $employeeId = $row->getEmployeeId();
        $service = $this->employee->getById($employeeId);
        return $service->getData('first_name') . " " .  $service->getData('last_name');
    }
}

