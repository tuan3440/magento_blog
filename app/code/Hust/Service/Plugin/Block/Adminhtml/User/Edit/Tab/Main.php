<?php

namespace Hust\Service\Plugin\Block\Adminhtml\User\Edit\Tab;

use Hust\Service\Ui\Component\Form\Employee\ListLocator;

class Main
{
    /** @var \Magento\Framework\Registry  */
    protected $_coreRegistry;
    protected $locator;

    public function __construct(\Magento\Framework\Registry $registry,
                                ListLocator $locator
    )
    {
        $this->locator = $locator;
        $this->_coreRegistry = $registry;
    }

    /**
     * Get form HTML
     *
     * @return string
     */
    public function aroundGetFormHtml(
        \Magento\User\Block\User\Edit\Tab\Main $subject,
        \Closure $proceed
    )
    {
        /** @var $model \Magento\User\Model\User */
        $model = $this->_coreRegistry->registry('permissions_user');

        $form = $subject->getForm();
        if (is_object($form)) {
            $fieldset = $form->addFieldset('cus_fieldsetname_code', ['legend' => __('Locator')]);
            $locators = [];
            $locators[] = ['value' => 0, 'label' => __("All")];
            $locatorsss = array_merge($locators, $this->locator->toOptionArray());
            $fieldset->addField(
                'locator_id',
                'select',
                [
                    'name' => 'locator_id',
                    'label' => __('Locator'),
                    'id' => 'locator_id',
                    'title' => __('Locator'),
                    'values' => $locatorsss
                ]
            );
            $form->addValues(
                [
                    'locator_id' => $model->getData('locator_id'),
                ]
            );
            $subject->setForm($form);
        }
        return $proceed();
    }
}
