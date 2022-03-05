<?php

namespace Hust\Service\Controller\Adminhtml\Locator;

use Hust\Service\Controller\Adminhtml\Locator;

class AvailableServices extends Locator
{
    public function execute()
    {
        $resultLayout = $this->layoutFactory->create();
        $resultLayout->getLayout()->getBlock('booking.locator.edit.tab.availableservices')
            ->setInServices($this->getRequest()->getPost('locator_services', null));
        return $resultLayout;
    }
}
