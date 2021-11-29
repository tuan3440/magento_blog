<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Controller\Locator;

use Magento\Framework\App\ResponseInterface;

class Booknow extends \Dco\Service\Controller\Index\Index
{

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Booking Now'));

        return $resultPage;
    }
}
