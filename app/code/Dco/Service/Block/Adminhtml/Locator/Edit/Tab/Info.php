<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Block\Adminhtml\Locator\Edit\Tab;

use Dco\Service\Model\Source\Country;
use Dco\Service\Model\System\Config\IsActive;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

class Info extends Generic
{
    /**
     * @var IsActive
     */
    private $isActive;

    /**
     * @var Country
     */
    private $country;

    /**
     * Info constructor.
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param IsActive $isActive
     * @param Country $country
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        IsActive $isActive,
        Country $country,
        array $data = []
    ) {
        $this->isActive = $isActive;
        $this->country = $country;

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

    /**
     * @return Info
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('booking_locator');

        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information')]
        );

        if ($model->getId()) {
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
            'select',
            [
                'name' => 'country',
                'label' => __('Country'),
                'options' => $this->country->toOptionArray(),
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
