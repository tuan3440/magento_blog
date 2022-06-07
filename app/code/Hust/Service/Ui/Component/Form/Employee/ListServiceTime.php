<?php

namespace Hust\Service\Ui\Component\Form\Employee;

use Magento\Framework\Data\OptionSourceInterface;

class ListServiceTime implements OptionSourceInterface
{

    public function toArray()
    {
        return [
            0 => __('Ngắn (0 - 30 phút)'),
            1 => __('Trung bình (30 phút - 1 giờ)'),
            2 => __('Dài (1 giờ - 2 giờ )'),
        ];
    }

    public function toOptionArray()
    {
        $data = [];
        foreach ($this->toArray() as $value => $label) {
            $data[] = ['value' => $value, 'label' => $label];
        }
        return $data;
    }
}

