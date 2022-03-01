<?php

namespace Hust\Service\Controller\Adminhtml\Service;

use Hust\Service\Controller\Adminhtml\Service;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Service
{

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            $serviceId = (int)$this->getRequest()->getParam('service_id');
            try {
                if ($serviceId) {
                    $model = $this->getServiceRepository()->getById($serviceId);
                } else {
                    $model = $this->getServiceFactory()->create();
                }
                $data = $this->prepareData($data);
                $model->addData($data);
                $this->getServiceRepository()->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['service_id' => $model->getId()]);
                    return;
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                if ($serviceId = (int)$this->getRequest()->getParam('service_id')) {
                    $this->_redirect('*/*/edit', ['service_id' => $serviceId]);
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
                $data['image'] = '';
            }
        }
        return $data;
    }
}
