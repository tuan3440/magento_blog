<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Block\Adminhtml\Locator;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;

class Edit extends Container
{

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
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
        $this->_blockGroup = 'Dco_Service';
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
        if ($this->coreRegistry->registry('booking_locator')->getId()) {
            return __("Edit Locator '%1'", $this->escapeHtml($this->coreRegistry->registry('booking_locator')->getName()));
        } else {
            return __('Add Locator');
        }
    }
}
