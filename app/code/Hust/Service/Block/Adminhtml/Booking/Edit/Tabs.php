<?php

namespace Hust\Service\Block\Adminhtml\Booking\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{
    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Backend\Model\Auth\Session $authSession, array $data = [])
    {
        parent::__construct($context, $jsonEncoder, $authSession, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('return_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Booking'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'information',
            [
                'label' => __('Information'),
                'title' => __('Information'),
                'content' => $this->getLayout()->createBlock('Hust\Service\Block\Adminhtml\Booking\Edit\Tab\Infomation')->toHtml(),
                'active' => true
            ]
        );
        parent::_beforeToHtml();
    }
}
