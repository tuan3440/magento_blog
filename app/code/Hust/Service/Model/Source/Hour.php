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
            self::HOUR_4 => __('11AM : 12AM'),
            self::HOUR_5 => __('13PM : 14PM'),
            self::HOUR_6 => __('14PM : 15PM'),
            self::HOUR_7 => __('15PM : 16PM'),
            self::HOUR_8 => __('16PM : 17PM'),
            self::HOUR_9 => __('17PM : 18PM'),
            self::HOUR_10 => __('18PM : 19PM'),
            self::HOUR_11 => __('19PM : 20PM'),
            self::HOUR_12 => __('20PM : 21PM'),
            self::HOUR_13 => __('21PM : 22PM')
        ];
    }
}
