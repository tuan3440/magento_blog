<?php

namespace Hust\Service\Block\Adminhtml\Locator\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Hust\Service\Model\Source\Hour as ListHour;
use Hust\Service\Model\ServiceRegistry;

class Hour extends Generic
{
    private $hour;
    private $serviceRegistry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        ServiceRegistry $serviceRegistry,
        ListHour $hour,
        array $data = [])
    {
        $this->hour = $hour;
        $this->serviceRegistry = $serviceRegistry;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->serviceRegistry->registry(\Hust\Service\Controller\Adminhtml\Locator\Edit::CURRENT_LOCATOR);

        $form = $this->_formFactory->create();
        $fieldGeneralInformation = $form->addFieldset(
            'hour',
            [
                'legend' => __('Hour')
            ]
        );

        $fieldGeneralInformation->addField(
            'hours',
            'multiselect',
            [
                'values' => $this->hour->toOptionArray(),
                'name' => 'hours[]',
                'label' => __('Hours'),
                'title' => __('Hours'),
                'value' => $model->getData('hours')
            ]
        );

        $this->setForm($form);
        return parent::_prepareForm();
    }
}
