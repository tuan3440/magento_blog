<?php

namespace Hust\Service\Block\Adminhtml\Locator\Edit\Tab;

use Hust\Service\Model\System\IsActive;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Hust\Service\Model\ServiceRegistry;
use Magento\Framework\Registry;

class Info extends Generic
{

    private $isActive;
    private $serviceRegistry;

    public function __construct(
        Context $context,
        ServiceRegistry $serviceRegistry,
        FormFactory $formFactory,
        IsActive $isActive,
        Registry $registry,
        array $data = []
    ) {
        $this->isActive = $isActive;
        $this->serviceRegistry = $serviceRegistry;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * View URL getter
     *
     * @param int $locatorId
     *
     * @return string
     */
    public function getViewUrl($locatorId)
    {
        return $this->getUrl('booking/*/*', ['locator_id' => $locatorId]);
    }

    protected function _prepareForm()
    {
        $model = $this->serviceRegistry->registry(\Hust\Service\Controller\Adminhtml\Locator\Edit::CURRENT_LOCATOR);

        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information')]
        );

        if ($model->getLocatorId()) {
            $fieldset->addField(
                'locator_id',
                'hidden',
                ['name' => 'locator_id']
            );
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'code',
            'text',
            [
                'name' => 'code',
                'label' => __('Code'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'address',
            'textarea',
            [
                'name' => 'address',
                'label' => __('Address'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'city',
            'text',
            [
                'name' => 'city',
                'label' => __('City'),
                'required' => true
            ]
        );


        $fieldset->addField(
            'country',
            'text',
            [
                'name' => 'country',
                'label' => __('Country'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Email'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'phone',
            'text',
            [
                'name' => 'phone',
                'label' => __('Phone Number'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'is_active',
                'options' => $this->isActive->toOptionArray()
            ]
        );

        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
