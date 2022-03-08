<?php

namespace Hust\Service\Ui\Component\Form\Employee;

use Hust\Service\Model\Repository\LocatorRepository;
use Magento\Framework\Data\OptionSourceInterface;

class ListLocator implements OptionSourceInterface
{
    private $locatorRepository;

    public function __construct(
        LocatorRepository $locatorRepository
    )
    {
        $this->locatorRepository = $locatorRepository;
    }

    public function toOptionArray()
    {
        $locators = $this->locatorRepository->getListLocator();
        $data = [];
        if ($locators) {
            foreach ($locators as $locator) {
                $data[] = ['value' => $locator->getLocatorId(), 'label' => $locator->getName()];
            }
        }
        return $data;
    }
}

