<?php

namespace Hust\Service\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Option\ArrayInterface;

class Hour implements OptionSourceInterface, ArrayInterface
{
    const HOUR_0 = 0;
    const HOUR_1 = 1;
    const HOUR_2 = 2;
    const HOUR_3 = 3;
    const HOUR_4 = 4;
    const HOUR_5 = 5;
    const HOUR_6 = 6;
    const HOUR_7 = 7;
    const HOUR_8 = 8;
    const HOUR_9 = 9;
    const HOUR_10 = 10;
    const HOUR_11 = 11;
    const HOUR_12 = 12;
    const HOUR_13 = 13;
    const HOUR_14 = 14;
    const HOUR_15 = 15;

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
            self::HOUR_0 => __('7AM'),
            self::HOUR_1 => __('8AM'),
            self::HOUR_2 => __('9AM'),
            self::HOUR_3 => __('10AM'),
            self::HOUR_4 => __('11AM'),
            self::HOUR_5 => __('12AM'),
            self::HOUR_6 => __('1PM'),
            self::HOUR_7 => __('2PM'),
            self::HOUR_8 => __('3PM'),
            self::HOUR_9 => __('4PM'),
            self::HOUR_10 => __('5PM'),
            self::HOUR_11 => __('6PM'),
            self::HOUR_12 => __('7PM'),
            self::HOUR_13 => __('8PM'),
            self::HOUR_14 => __('9PM'),
            self::HOUR_15 => __('10PM')
        ];
    }
}
