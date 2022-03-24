<?php

namespace Hust\Service\Controller\Adminhtml\Promotion;

use Hust\Service\Controller\Adminhtml\Promotion;

class Delete extends Promotion
{

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = (int)$this->getRequest()->getParam('promotion_id');
        if ($id) {
            try {
                $this->getPromotionRepository()->deleteById($id);
                $this->getMessageManager()->addSuccessMessage(__('You deleted promotion.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['promotion_id' => $id]);
            }
        }
        $this->getMessageManager()->addErrorMessage(__('We can\'t find a promotion to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}

