<?php

namespace Hust\Service\Block\Adminhtml\Grid\Columns\Renderer;

use Magento\Backend\Block\Context;
use Hust\Service\Model\Source\Hour as BookingHour;
use Magento\Framework\DataObject;

class Hour extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $hour;
    public function __construct(Context $context,BookingHour $hour, array $data = [])
    {
        $this->hour = $hour;
        parent::__construct($context, $data);
    }

    public function render(DataObject $row)
    {
        $hour = $row->getBookingHour();
        $hours = $this->hour->toArray();
        return $hours[$hour];
    }

}
