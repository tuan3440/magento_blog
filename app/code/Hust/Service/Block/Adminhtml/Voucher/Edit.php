<?php

namespace Hust\Service\Block\Adminhtml\Voucher;

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
       $this->_objectId = 'voucher_id';
       $this->_blockGroup = 'Hust_Service';
       $this->_controller = 'adminhtml_voucher';

       parent::_construct();

       $this->buttonList->update('save', 'label', __('Generate Voucher'));

   }
}
