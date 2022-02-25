<?php

namespace Hust\Service\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Option\ArrayInterface;

class BookingStatus implements OptionSourceInterface, ArrayInterface
{
    const WAITING = 0;
    const ACCEPT = 1;
    const DECLINE = 2;
    const SUCCESS = 3;
    const BOOM = 4;
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $optionArray = [];
        foreach ($this->toArray() as $value => $label) {
            $optionArray[] = ['value' => $value, 'label' => $label];
        }

        return $optionArray;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::WAITING => __('Waitng'),
            self::ACCEPT => __('Accept'),
            self::DECLINE => __("Decline"),
            self::SUCCESS => __("Success"),
            self::BOOM => __("Boom")
        ];
    }
}
