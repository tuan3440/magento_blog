<?php

namespace Hust\Service\Block\Locator;

use Magento\Framework\View\Element\Template;
use Hust\Service\Model\LocatorFactory;

class View extends Template
{
    protected $locator;

    public function __construct(Template\Context $context,
                                LocatorFactory $locatorFactory,
                                array $data = [])
    {
        $this->locator = $locatorFactory;
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
        return $this->getRequest()->getParam('service') ? $this->getRequest()->getParam('id') : null;
    }
}
