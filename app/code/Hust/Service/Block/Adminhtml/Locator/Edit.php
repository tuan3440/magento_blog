<?php

namespace Hust\Service\Block\Adminhtml\Locator;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;
use Hust\Service\Model\ServiceRegistry;

class Edit extends Container
{

    private $serviceRegistry;

    public function __construct(
        Context $context,
        ServiceRegistry $registry,
        array $data = []
    ) {
        $this->serviceRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize Locator edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'locator_id';
        $this->_blockGroup = 'Hust_Service';
        $this->_controller = 'adminhtml_locator';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Locator'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
        $this->buttonList->update('delete', 'label', __('Delete Locator'));
    }

    /**
     * Retrieve text for header element depending on loaded post
     *
     * @return Phrase
     */
    public function getHeaderText()
    {
        if ($this->serviceRegistry->registry(\Hust\Service\Controller\Adminhtml\Locator\Edit::CURRENT_LOCATOR)->getLocatorId()) {
            return __("Edit Locator '%1'", $this->escapeHtml($this->serviceRegistry->registry(\Hust\Service\Controller\Adminhtml\Locator\Edit::CURRENT_LOCATOR)->getName()));
        } else {
            return __('Add Locator');
        }
    }
}

