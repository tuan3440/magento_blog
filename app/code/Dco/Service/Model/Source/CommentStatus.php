<?php

namespace Dco\Service\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Option\ArrayInterface;

class CommentStatus implements OptionSourceInterface, ArrayInterface
{
    const PENDING = 0;
    const ACCEPT = 1;
    const REJECT = 2;

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
            self::PENDING => __('Pending'),
            self::ACCEPT => __('Accept'),
            self::REJECT => __("Reject")
        ];
    }
}

