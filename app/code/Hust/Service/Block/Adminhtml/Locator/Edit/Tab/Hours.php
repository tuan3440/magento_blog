<?php

namespace Hust\Service\Block\Adminhtml\Locator\Edit\Tab;

use Hust\Service\Model\ServiceRegistry;
use Hust\Service\Model\System\IsActive;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Hust\Service\Model\Source\Hour;

class Hours extends Generic
{

    private $isActive;
    private $serviceRegistry;
    private $hours;

    public function __construct(
        Context $context,
        ServiceRegistry $serviceRegistry,
        FormFactory $formFactory,
        IsActive $isActive,
        Registry $registry,
        Hour $hours,
        array $data = []
    ) {
        $this->hours = $hours;
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
            ['legend' => __('Hour')]
        );

//        if ($model->getLocatorId()) {
//            $fieldset->addField(
//                'locator_id',
//                'hidden',
//                ['name' => 'locator_id']
//            );
//        }

        $fieldset->addField(
            'hours',
            'multiselect',
            [
                'name' => 'hours',
                'label' => __('Hour Active'),
                'required' => true,
                'values' => $this->hours->toOptionArray()
            ]
        );


        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

