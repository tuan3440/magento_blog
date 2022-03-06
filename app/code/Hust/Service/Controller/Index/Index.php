<?php

namespace Hust\Service\Controller\Index;

use Magento\Framework\App\ResponseInterface;

class Index extends \Hust\Service\Controller\Index
{

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Spa Services'));

        return $resultPage;
    }
}
