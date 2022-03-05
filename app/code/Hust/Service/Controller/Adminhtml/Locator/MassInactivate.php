<?php

namespace Hust\Service\Controller\Adminhtml\Locator;

use Hust\Service\Model\Source\LocatorStatus;

class MassInactivate extends AbstractMassAction
{
    /**
     * @param $service
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    protected function itemAction($locator)
    {
        try {
            $locator->setIsActive(LocatorStatus::DISABLED);
            $this->getRepository()->save($locator);
        } catch (\Exception $e) {
            $this->getMessageManager()->addErrorMessage($e->getMessage());
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}

