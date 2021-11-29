<?php

namespace Dco\Service\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Option\ArrayInterface;

class Status implements OptionSourceInterface, ArrayInterface
{
    const DISABLED = 0;
    const ENABLED = 1;

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
            self::DISABLED => __('Disabled'),
            self::ENABLED => __('Enabled')
        ];
    }
}
