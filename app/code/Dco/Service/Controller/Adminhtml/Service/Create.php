<?php

namespace Dco\Service\Controller\Adminhtml\Service;

use Magento\Framework\App\ResponseInterface;

class Create extends \Dco\Service\Controller\Adminhtml\Service
{
    /**
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
