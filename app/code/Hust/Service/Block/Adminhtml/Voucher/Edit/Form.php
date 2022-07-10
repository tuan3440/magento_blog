<?php

namespace Hust\Service\Block\Adminhtml\Voucher\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Class Form
 * @package ViMagento\HelloWorld\Block\Adminhtml\Edit
 */
class Form extends Generic
{
    /**
     * @return Form
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ]
            ]
        );

        $form->setUseContainer(true);

        $fieldsets = $form->addFieldset(
            'field_set_example',
            ['legend' => __('General')]
        );
        $fieldsets->addField(
            'count',
            'text',
            [
                'name' => 'count',
                'label' => __('Count voucher'),
                'title' => __('Count voucher'),
                'required' => true
            ]
        );
        $fieldsets->addField(
            'discount',
            'text',
            [
                'name' => 'discount',
                'title' => __('Discount(%)'),
                'label' => __('Discount(%)'),
                'required' => true
            ]
        );

        $fieldsets->addField(
            'date_end',
            'date',
            [
                'name' => 'date_end',
                'title' => __('Expire Date'),
                'label' => __('Expire Date'),
                'required' => true,
                'date_format' => 'yyyy-MM-dd'
            ]
        );

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
