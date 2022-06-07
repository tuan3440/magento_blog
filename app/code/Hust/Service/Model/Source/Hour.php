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
    const HOUR_16 = 16;
    const HOUR_17 = 17;
    const HOUR_18 = 18;
    const HOUR_19 = 19;
    const HOUR_20 = 20;
    const HOUR_21 = 21;
    const HOUR_22 = 22;
    const HOUR_23 = 23;
    const HOUR_24 = 24;
    const HOUR_25 = 25;
    const HOUR_26 = 26;
    const HOUR_27 = 27;

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
            self::HOUR_0 => __('7AM : 8AM'),
            self::HOUR_1 => __('8AM : 9AM'),
            self::HOUR_2 => __('9AM : 10AM'),
            self::HOUR_3 => __('10AM : 11M'),
            self::HOUR_4 => __('1PM : 2PM'),
            self::HOUR_5 => __('2PM : 3PM'),
            self::HOUR_6 => __('3PM : 4PM'),
            self::HOUR_7 => __('4PM : 5PM'),
            self::HOUR_8 => __('7AM : 7:30AM'),
            self::HOUR_9 => __('7:30AM : 8AM'),
            self::HOUR_10 => __('8AM : 8:30AM'),
            self::HOUR_11 => __('8:30AM : 9M'),
            self::HOUR_12 => __('9AM : 9:30AM'),
            self::HOUR_13 => __('9:30AM : 10AM'),
            self::HOUR_14 => __('10AM : 10:30AM'),
            self::HOUR_15 => __('10:30AM : 11M'),
            self::HOUR_16 => __('1PM : 1:30PM'),
            self::HOUR_17 => __('1:30PM : 2PM'),
            self::HOUR_18 => __('2PM : 2:30PM'),
            self::HOUR_19 => __('2:30PM : 3PM'),
            self::HOUR_20=> __('3PM : 3:30PM'),
            self::HOUR_21 => __('3:30PM : 4PM'),
            self::HOUR_22 => __('4PM : 4:30PM'),
            self::HOUR_23 => __('4:30PM : 5PM'),
            self::HOUR_24 => __('7AM : 9AM'),
            self::HOUR_25 => __('9AM : 11AM'),
            self::HOUR_26 => __('1PM : 3PM'),
            self::HOUR_27 => __('3PM : 5PM'),
        ];
    }
}
