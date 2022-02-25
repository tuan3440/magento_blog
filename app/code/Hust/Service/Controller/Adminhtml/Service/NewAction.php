<?php

namespace Hust\Service\Controller\Adminhtml\Service;


use Hust\Service\Controller\Adminhtml\Service;
use Magento\Framework\App\ResponseInterface;

class NewAction extends Service
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
