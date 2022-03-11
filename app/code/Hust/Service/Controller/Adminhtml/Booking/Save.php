<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;
use Magento\Framework\App\ResponseInterface;

class Save extends Booking
{

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $b = 1;
    }
}
