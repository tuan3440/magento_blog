<?php

namespace Hust\Service\Controller\Adminhtml\Service;

use Hust\Service\Controller\Adminhtml\Service;
use Magento\Framework\App\ResponseInterface;

class Delete extends Service
{

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = (int)$this->getRequest()->getParam('service_id');
        if ($id) {
            try {
                $this->getServiceRepository()->deleteById($id);
                $this->getMessageManager()->addSuccessMessage(__('You deleted service.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['service_id' => $id]);
            }
        }
        $this->getMessageManager()->addErrorMessage(__('We can\'t find a service to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
