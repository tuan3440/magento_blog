<?php

namespace Hust\Service\Controller\Adminhtml\Locator;

use Hust\Service\Controller\Adminhtml\Locator;
use Magento\Framework\App\ResponseInterface;

class NewAction extends Locator
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
