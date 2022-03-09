<?php

namespace Hust\Service\Block\Locator;

use Magento\Framework\View\Element\Template;
use Hust\Service\Model\LocatorFactory;
use Hust\Service\Model\Source\Hour;

class View extends Template
{
    protected $locator;
    protected $hours;

    public function __construct(Template\Context $context,
                                LocatorFactory $locatorFactory,
                                Hour $hours,
                                array $data = [])
    {
        $this->locator = $locatorFactory;
        $this->hours = $hours;
        parent::__construct($context, $data);
    }

    public function getLocator()
    {
        $locator_id = $this->getRequest()->getParam('id');
        $locatorCurrent = $this->locator->create()->load($locator_id);
        return $locatorCurrent;
    }



    public function getServiceId()
    {
        return $this->getRequest()->getParam('service');
    }

    public function getHours()
    {
        return $this->hours->toArray();
    }
}
