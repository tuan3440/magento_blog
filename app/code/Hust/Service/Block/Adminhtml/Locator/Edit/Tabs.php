<?php

namespace Hust\Service\Block\Adminhtml\Locator\Edit;

use Hust\Service\Block\Adminhtml\Locator\Edit\Tab\Info;
use Hust\Service\Block\Adminhtml\Locator\Edit\Tab\Hour;

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
                'label' => __('Available Service'),
                'title' => __('Available Service'),
                'url' => $this->getUrl('*/*/availableservices', ['_current' => true]),
                'class' => 'ajax',
                'active' => false
            ]
        );

        $this->addTab(
            'hour_service',
            [
                'label' => __('Hour'),
                'title' => __('Hour'),
                'content' => $this->getLayout()->createBlock(
                    Hour::class
                )->toHtml(),
                'active' => false
            ]
        );

        return parent::_beforeToHtml();
    }
}

