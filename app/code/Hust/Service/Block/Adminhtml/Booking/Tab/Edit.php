<?php

namespace Hust\Service\Block\Adminhtml\Booking\Tab;

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
        $this->_controller = 'adminhtml_booking_tab'; //name folder chứa Edit.php
        parent::_construct();

        $this->buttonList->remove('delete');
        $this->buttonList->remove('reset');
//        $this->buttonList->remove('delete');
//
//        $this->addButton('pdf', array(
//            'label'     => __('Render pdf'),
//            'onclick'   => "setLocation('" . $this->getUrl('*/*/exportReturnItemPdf', array('id'=>$this->getRequest()->getParam('id'), '_current'=>true)) . "')",
//            'class'     => 'save',
//        ), 100);
//
//        $this->addButton('send_email_customer', array(
//            'label'     => __('Pdf send Customer'),
//            'onclick'   => "setLocation('" . $this->getUrl('*/*/exportReturnCustomer', array('id'=>$this->getRequest()->getParam('id'), '_current'=>true)) . "')",
//            'class'     => 'save',
//        ), 100);
//
//        $this->addButton('save_and_send_delivery_date_mail',[
//            'label'     => __('Save And Send Mail'),
//            'class'     => 'save',
//            'data_attribute' => [
//                'mage-init' => [
//                    'button' => [
//                        'event' => 'save',
//                        'target' => '#edit_form',
//                        'eventData' => ['action' => ['args' => ['save_and_send_mail' => '1']]],
//                    ],
//                ]
//            ]
//        ], 100);
//
//        $this->addButton('save_and_send_mail',[
//            'label'     => __('Save And Send Delivery Date Mail'),
//            'class'     => 'save',
//            'data_attribute' => [
//                'mage-init' => [
//                    'button' => [
//                        'event' => 'save',
//                        'target' => '#edit_form',
//                        'eventData' => ['action' => ['args' => ['send_delivery_date_mail' => '1']]],
//                    ],
//                ]
//            ]
//        ], 100);
    }
}


