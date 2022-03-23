<?php

namespace Hust\Service\Controller\Adminhtml\Promotion;

use Hust\Service\Controller\Adminhtml\Promotion;

class NewAction extends Promotion
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
