<?php

namespace Hust\Service\Controller\Adminhtml\Service;

use Hust\Service\Controller\Adminhtml\Service;
use Magento\Framework\App\ObjectManager;
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
                $this->saveProductRelative($model);
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
                $data['image'] = $data['image'][0]['name'];
            }
        }
        return $data;
    }

    private function saveProductRelative($model)
    {
        if (isset($model['related_products_container'])) {
            try {
                $this->_resources = ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();

                $table = $this->_resources->getTableName('hust_service_products');
                $where = [
                    'service_id = ?' => (int)$model->getId()
                ];
                $connection->delete($table, $where);

                if ($model['related_products_container']) {
                    $data = [];
                    foreach ($model['related_products_container'] as $product) {
                        $data[] = [
                            'service_id' => $model->getId(),
                            'product_id' => $product['entity_id'],
                            'position' => $product['amasty_blog_position']
                        ];
                    }
                    $connection->insertMultiple($table, $data);
                }
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the services.'));
            }
        }
    }
}
