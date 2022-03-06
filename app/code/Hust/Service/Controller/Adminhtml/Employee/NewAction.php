<?php

namespace Hust\Service\Controller\Adminhtml\Employee;

use Hust\Service\Controller\Adminhtml\Employee;
use Magento\Framework\App\ResponseInterface;

class NewAction extends Employee
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
