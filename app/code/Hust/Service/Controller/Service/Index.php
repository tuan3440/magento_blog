<?php

namespace Hust\Service\Controller\Service;

use Magento\Framework\App\ResponseInterface;

class Index extends \Dco\Service\Controller\Index
{
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Spa Services'));

        return $resultPage;
    }
}
