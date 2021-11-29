<?php
namespace Dco\Service\Controller\Index;

use Magento\Framework\View\Result\Page;

class Index extends \Dco\Service\Controller\Index
{
    /**
     * @return Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Spa Services'));

        return $resultPage;
    }
}
