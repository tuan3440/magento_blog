<?php

namespace Dco\Service\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Option\ArrayInterface;

class Hour implements OptionSourceInterface, ArrayInterface
{
    const HOUR_0 = 0;
    const HOUR_1 = 1;
    const HOUR_2 = 2;
    const HOUR_3 = 3;

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
            self::HOUR_0 => __('7AM : 9AM'),
            self::HOUR_1 => __('9AM : 11AM'),
            self::HOUR_2 => __('1PM : 3PM'),
            self::HOUR_3 => __('3PM : 5PM')
        ];
    }
}
