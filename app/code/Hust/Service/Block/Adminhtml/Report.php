<?php

namespace Hust\Service\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Report extends Container
{
    /**
     * Template file
     *
     * @var string
     */
//    protected $_template = 'OpenTechiz_ProductionReport::report/grid/container.phtml';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Hust_Service';
        $this->_controller = 'adminhtml_report';
        $this->_headerText = __('Report Booking');
        parent::_construct();
        $this->buttonList->remove('add');
        $this->addButton(
            'filter_form_submit',
            ['label' => __('Show Report'), 'onclick' => 'filterFormSubmit()', 'class' => 'primary']
        );
    }

    /**
     * Get filter URL
     *
     * @return string
     */
    public function getFilterUrl()
    {
        $this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/index', ['_current' => true]);
    }
}
