<?php

namespace Hust\Service\Controller\Adminhtml\Locator;

use Hust\Service\Controller\Adminhtml\Locator\AbstractMassAction;
use Hust\Service\Model\Source\LocatorStatus;

class MassActivate extends AbstractMassAction
{
    protected function itemAction($locator)
    {
        try {
            $locator->setIsActive(LocatorStatus::ENABLED);
            $this->getRepository()->save($locator);
        } catch (\Exception $e) {
            $this->getMessageManager()->addErrorMessage($e->getMessage());
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
