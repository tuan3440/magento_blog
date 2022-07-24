<?php

namespace Hust\Service\Controller\Locator;

use Hust\Service\Controller\Index;

class Booking extends Index
{
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
//        $resultPage->getConfig()->getTitle()->set(__('Booking Now'));

        return $resultPage;
    }
}
