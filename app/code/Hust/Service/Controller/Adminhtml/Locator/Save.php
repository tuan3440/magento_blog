<?php

namespace Hust\Service\Controller\Adminhtml\Locator;

use Hust\Service\Controller\Adminhtml\Locator;
use Hust\Service\Model\LocatorFactory;
use Hust\Service\Model\Repository\LocatorRepository;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\Helper\Js;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;

class Save extends Locator
{
    private $_jsHelper;
    public function __construct(Context $context,
                                PageFactory $resultPageFactory,
                                LocatorFactory $locatorFactory,
                                LocatorRepository $locatorRepository,
                                ServiceRegistry $serviceRegistry,
                                LayoutFactory $layoutFactory,
                                Js  $_jsHelper
    )
    {
        $this->_jsHelper = $_jsHelper;
        parent::__construct($context, $resultPageFactory, $locatorFactory, $locatorRepository, $serviceRegistry, $layoutFactory);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            $locatorId = (int)$this->getRequest()->getParam('locator_id');
            try {
                if ($locatorId) {
                    $model = $this->getLocatorRepository()->getById($locatorId);
                } else {
                    $model = $this->getLocatorFactory()->create();
                }
                $model->addData($data);
                $this->getLocatorRepository()->save($model);
                $this->saveService($model, $data);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['locator_id' => $model->getId()]);
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

    private function saveService($model, $postData)
    {
        if (isset($postData['services'])) {
            $serviceIds = $this->_jsHelper->decodeGridSerializedInput($postData['services']);
            try {
                $newServices = (array)$serviceIds;
                $this->_resources = ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();

                $table = $this->_resources->getTableName('hust_service_locator');
                $where = [
                    'locator_id = ?' => (int)$model->getId()
                ];
                $connection->delete($table, $where);

                if ($newServices) {
                    $data = [];
                    foreach ($newServices as $service_id) {
                        $data[] = [
                            'service_id' => $service_id,
                            'locator_id' => $model->getId(),
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
