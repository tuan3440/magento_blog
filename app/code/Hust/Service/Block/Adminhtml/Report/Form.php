<?php

namespace Hust\Service\Block\Adminhtml\Report;

use IntlDateFormatter;
use Hust\Service\Ui\Component\Form\Employee\ListService;
use Hust\Service\Ui\Component\Form\Employee\ListLocator;
use Magento\Backend\Block\Widget\Form\Element\Dependence;

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

       $htmlIdPrefix = 'production_report_reportitems_';
       $form->setHtmlIdPrefix($htmlIdPrefix);
       $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Filter')]);

       $dateFormat = $this->_localeDate->getDateFormat(IntlDateFormatter::SHORT);
       $fieldset->addField(
           'period_type',
           'select',
           [
               'name' => 'period_type',
               'options' => ['day' => __('Day'), 'month' => __('Month'), 'year' => __('Year')],
               'label' => __('Period'),
               'title' => __('Period')
           ]
       );

       $fieldset->addField(
           'from',
           'date',
           [
               'name' => 'from',
               'date_format' => $dateFormat,
               'label' => __('From'),
               'title' => __('From'),
               'required' => true,
               'css_class' => 'admin__field-small',
               'class' => 'admin__control-text'
           ]
       );

       $fieldset->addField(
           'to',
           'date',
           [
               'name' => 'to',
               'date_format' => $dateFormat,
               'label' => __('To'),
               'title' => __('To'),
               'required' => true,
               'css_class' => 'admin__field-small',
               'class' => 'admin__control-text'
           ]
       );

       $fieldset->addField(
           'show_order_statuses',
           'select',
           [
               'name' => 'show_order_statuses',
               'label' => __('Type Filter'),
               'options' => ['0' => __('Any'), '1' => __('Locator'), '2' => __('Service')],
               'note' => __('Filter for locator,service')
           ],
           'to'
       );



       $fieldset->addField(
           'service_id',
           'multiselect',
           [
               'name' => 'service_id',
               'label' => __('Service'),
               'values' => $this->service->toOptionArray(),
               'display' => 'none'
           ],
           'show_order_statuses'
       );

       $fieldset->addField(
           'locator_id',
           'multiselect',
           [
               'name' => 'locator_id',
               'label' => __('Locator'),
               'values' => $this->locator->toOptionArray(),
               'display' => 'none'
           ],
           'show_order_statuses'
       );

       if ($this->getFieldVisibility('show_order_statuses')) {
           $this->setChild(
               'form_after',
               $this->getLayout()->createBlock(Dependence::class)
                   ->addFieldMap("{$htmlIdPrefix}show_order_statuses", 'show_order_statuses')
                   ->addFieldMap("{$htmlIdPrefix}service_id", 'service_id')
                   ->addFieldMap("{$htmlIdPrefix}locator_id", 'locator_id')
                   ->addFieldDependence('service_id', 'show_order_statuses', '2')
                   ->addFieldDependence('locator_id', 'show_order_statuses', '1')
           );
       }

       $form->setUseContainer(true);
       $this->setForm($form);

       return parent::_prepareForm();
   }

}
