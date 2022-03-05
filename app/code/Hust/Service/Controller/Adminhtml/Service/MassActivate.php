<?php

namespace Hust\Service\Controller\Adminhtml\Service;

use Hust\Service\Controller\Adminhtml\Service\AbstractMassAction;
use Hust\Service\Model\Source\ServiceStatus;

class MassActivate extends AbstractMassAction
{
    /**
     * @param $service
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    protected function itemAction($service)
    {
        try {
            $service->setIsActive(ServiceStatus::ENABLED);
            $this->getRepository()->save($service);
        } catch (\Exception $e) {
            $this->getMessageManager()->addErrorMessage($e->getMessage());
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
