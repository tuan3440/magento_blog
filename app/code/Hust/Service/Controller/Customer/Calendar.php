<?php

namespace Hust\Service\Controller\Customer;

class Calendar extends \Magento\Framework\App\Action\Action {
    public function execute() {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
