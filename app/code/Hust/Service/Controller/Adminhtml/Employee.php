<?php

namespace Hust\Service\Controller\Adminhtml;

use Hust\Service\Model\EmployeeFactory;
use Hust\Service\Model\Repository\EmployeeRepository;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;

abstract class Employee extends Action
{
    const ADMIN_RESOURCE = 'Hust_Service::hust_employee';

    protected $resultPageFactory;
    private $employeeFactory;
    private $employeeRepository;
    private $serviceRegistry;
    protected $layoutFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        EmployeeFactory $employeeFactory,
        EmployeeRepository $employeeRepository,
        ServiceRegistry $serviceRegistry,
        LayoutFactory $layoutFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->employeeFactory = $employeeFactory;
        $this->employeeRepository = $employeeRepository;
        $this->serviceRegistry = $serviceRegistry;
        $this->layoutFactory = $layoutFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }

    protected function getEmployeeFactory()
    {
        return $this->employeeFactory;
    }

    protected function getEmployeeRepository()
    {
        return $this->employeeRepository;
    }

    protected function getServiceRegistry()
    {
        return $this->serviceRegistry;
    }


}

