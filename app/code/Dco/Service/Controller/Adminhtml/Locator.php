<?php

namespace Dco\Service\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class Locator extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dco_Service::service_locator';
}
