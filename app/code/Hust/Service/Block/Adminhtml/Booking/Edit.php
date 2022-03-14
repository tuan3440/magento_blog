<?php

namespace Hust\Service\Block\Adminhtml\Booking;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

class Edit extends Container
{

    public function __construct(Context $context, array $data = [], ?SecureHtmlRenderer $secureRenderer = null)
    {
        parent::__construct($context, $data, $secureRenderer);
    }

    protected function _construct()
    {
        $this->_blockGroup = 'Hust_Service'; //name Vendor_Module
        $this->_controller = 'adminhtml_booking'; //name folder chứa Edit.php
        parent::_construct();

        $this->buttonList->remove('delete');
        $this->buttonList->remove('reset');
    }
}


