<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Controller\Adminhtml\Locator;

use Dco\Service\Controller\Adminhtml\Locator;

class Create extends Locator
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
