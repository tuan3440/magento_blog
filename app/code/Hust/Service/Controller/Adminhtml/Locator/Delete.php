<?php

namespace Hust\Service\Controller\Adminhtml\Locator;

use Hust\Service\Controller\Adminhtml\Locator;
use Magento\Framework\App\ResponseInterface;

class Delete extends Locator
{
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = (int)$this->getRequest()->getParam('locator_id');
        if ($id) {
            try {
                $this->getLocatorRepository()->deleteById($id);
                $this->getMessageManager()->addSuccessMessage(__('You deleted locator.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['locator_id' => $id]);
            }
        }
        $this->getMessageManager()->addErrorMessage(__('We can\'t find a locator to delete.'));

        return $resultRedirect->setPath('*/*/');    }
}
