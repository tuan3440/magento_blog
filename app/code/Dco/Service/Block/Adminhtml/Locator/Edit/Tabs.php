<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Block\Adminhtml\Locator\Edit;

use Dco\Service\Block\Adminhtml\Locator\Edit\Tab\Info;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('booking_locator_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Locator Edit'));
    }

    /**
     * {@inheritdoc}
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'locator_info',
            [
                'label' => __('General Information'),
                'title' => __('General Information'),
                'content' => $this->getLayout()->createBlock(
                    Info::class
                )->toHtml(),
                'active' => true
            ]
        );

        $this->addTab(
            'available_service',
            [
                'label' => __('Available Services'),
                'title' => __('Available Services'),
                'url' => $this->getUrl('*/*/availableservices', ['_current' => true]),
                'class' => 'ajax',
                'active' => false
            ]
        );

        return parent::_beforeToHtml();
    }
}
