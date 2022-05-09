<?php

namespace Hust\Service\Block\Adminhtml\Schedule;

use Hust\Service\Ui\Component\Form\Employee\ListLocator;
use Hust\Service\Ui\Component\Form\Employee\ListService;
use Magento\Backend\Block\Widget\Form\Element\Dependence;
use \IntlDateFormatter;

class Form extends \Hust\Service\Block\Adminhtml\Filter\Form
{
    protected $service;
    protected $locator;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        ListLocator $locator,
        ListService $service,
        array $data = [])
    {
        $this->service = $service;
        $this->locator = $locator;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $actionUrl = $this->getUrl('*/*/');
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'filter_form',
                    'action' => $actionUrl,
                    'method' => 'get'
                ]
            ]
        );

        $htmlIdPrefix = 'booking_schedule_';
        $form->setHtmlIdPrefix($htmlIdPrefix);
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Filter')]);

        $dateFormat = $this->_localeDate->getDateFormat(IntlDateFormatter::SHORT);

        $fieldset->addField(
            'date',
            'date',
            [
                'name' => 'date',
                'date_format' => $dateFormat,
                'label' => __('Date'),
                'title' => __('Date'),
                'required' => true,
                'css_class' => 'admin__field-small',
                'class' => 'admin__control-text',
            ]
        );


        $fieldset->addField(
            'locator_id',
            'select',
            [
                'name' => 'locator_id',
                'label' => __('Locator'),
                'values' => $this->locator->toOptionArray(),
                'display' => 'none'
            ],
            'date'
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}

