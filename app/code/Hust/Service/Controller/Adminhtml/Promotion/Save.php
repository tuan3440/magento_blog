<?php

namespace Hust\Service\Controller\Adminhtml\Promotion;

use Hust\Service\Controller\Adminhtml\Promotion;
use Magento\Framework\Exception\LocalizedException;

class Save extends Promotion
{
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            $promotionId = (int)$this->getRequest()->getParam('promotion_id');
            try {
                if ($promotionId) {
                    $model = $this->getPromotionRepository()->getById($promotionId);
                } else {
                    $model = $this->getPromotionFactory()->create();
                }
                $data = $this->prepareData($data);
                $model->addData($data);
                $this->getPromotionRepository()->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['promotion_id' => $model->getId()]);
                    return;
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                if ($serviceId = (int)$this->getRequest()->getParam('promotion_id')) {
                    $this->_redirect('*/*/edit', ['promotion_id' => $serviceId]);
                } else {
                    $this->_redirect('*/*/');
                }
                return;
            }
            $this->_redirect('*/*/');
        }
    }

    private function prepareData(array $data)
    {
        if (isset($data['image']) && is_array(($data['image']))) {
            if (isset($data['image'][0]['name']) && isset($data['image'][0]['tmp_name'])) {
                $data['image'] = $data['image'][0]['file'];
            } else {
                $data['image'] = $data['image'][0]['name'];
            }
        }
        if (is_array($data['service_id'])) {
            $data['service_id'] = implode(',', $data['service_id']);
        }
        return $data;
    }
}
