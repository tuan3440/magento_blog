<?php

namespace Hust\Service\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

abstract class Promotion extends Action
{
    const ADMIN_RESOURCE = 'Hust_Service::hust_promotion';
    protected $resultPageFactory;

    public function __construct(
        PageFactory $pageFactory,
        Context $context
    )
    {
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }

}
