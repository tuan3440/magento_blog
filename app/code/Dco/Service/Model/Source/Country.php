<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Model\Source;

use Magento\Directory\Model\ResourceModel\Country\Collection as CountryCollection;
use Magento\Framework\Data\OptionSourceInterface;

class Country implements OptionSourceInterface
{

    /**
     * Countries
     *
     * @var CountryCollection
     */
    private $countryCollection;

    /**
     * @param CountryCollection $countryCollection
     */
    public function __construct(CountryCollection $countryCollection)
    {
        $this->countryCollection = $countryCollection;
    }

    /**
     * Options array
     *
     * @var array
     */
    private $options;

    /**
     * Return options array
     *
     * @param boolean $isMultiselect
     * @param string|array $foregroundCountries
     * @return array
     */
    public function toOptionArray($isMultiselect = false, $foregroundCountries = '')
    {
        $optionsArr = [];
        if (!$this->options) {
            $this->options = $this->countryCollection->loadData()->setForegroundCountries(
                $foregroundCountries
            )->toOptionArray(
                false
            );
        }

        $options = $this->options;
        if (!$isMultiselect) {
            array_unshift($options, ['value' => '', 'label' => __('--Please Select--')]);
        }

        foreach ($options as $option) {
            $optionsArr[$option['value']] = $option['label'];
        }

        return $optionsArr;
    }
}
