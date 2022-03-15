<?php

namespace Hust\Service\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Hust\Service\Block\Adminhtml\Report;

class Grid extends Action
{
    public function _initAction()
    {
        $this->_view->loadLayout();
        return $this;
    }

    public function execute()
    {
        $this->_view->loadLayout();
        $this->getResponse()->setBody(
            $this->_view->getLayout()->createBlock(Report::class)->toHtml()
        );
    }
}
