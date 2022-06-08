<?php

namespace Hust\Service\Block\Adminhtml\Booking;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Hust\Service\Model\ServiceRegistry;

class Edit extends Container
{
    private $serviceRegistry;
    public function __construct(Context $context,
                                ServiceRegistry $serviceRegistry,
                                array $data = [],
                                ?SecureHtmlRenderer $secureRenderer = null
    )
    {
        $this->serviceRegistry = $serviceRegistry;
        parent::__construct($context, $data, $secureRenderer);
    }

    protected function _construct()
    {
        $this->_blockGroup = 'Hust_Service'; //name Vendor_Module
        $this->_controller = 'adminhtml_booking'; //name folder chứa Edit.php
        parent::_construct();

        $this->buttonList->remove('delete');
        $this->buttonList->remove('reset');

        if ($this->getBooking()->getBookingStatus() == 3) {
            $this->buttonList->add(
                'print',
                [
                    'label' => __('Print'),
                    'class' => 'print',
                    'onclick' => 'setLocation(\'' . $this->getPrintUrl() . '\')'
                ]
            );
        }

    }

    public function getBooking()
    {
        return $this->serviceRegistry->registry('booking_current');
    }

    public function getPrintUrl()
    {
        return $this->getUrl('booking/*/print', ['booking' => $this->getBooking()->getBookingId()]);
    }
}


