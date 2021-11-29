<?php
/**
 * Copyright © OpenTechiz, VietNam. All rights reserved.
 * See COPYING.txt for license details.
 * @package        OpenTechiz
 * @author         vuthuan <support@opentechiz.com>
 * @copyright      2021 Vu Thuan (03 2808 3090)
 */

namespace Dco\Service\Block\Locator;

use Magento\Framework\View\Element\Template;
use Dco\Service\Model\LocatorFactory;


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
