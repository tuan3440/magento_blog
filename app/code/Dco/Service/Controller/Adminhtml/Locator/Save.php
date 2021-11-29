<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Controller\Adminhtml\Locator;

use Dco\Service\Api\LocatorRepositoryInterface;
use Dco\Service\Controller\Adminhtml\Locator;
use Dco\Service\Model\LocatorFactory as LocatorFactory;
use Exception;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Locator
{
    /**
     * @var LocatorRepositoryInterface
     */
    private $repository;

    /**
     * @var LocatorFactory
     */
    private $locatorFactory;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Js
     */
    private $_jsHelper;

    public function __construct(
        Context $context,
        LocatorFactory $locatorFactory,
        LocatorRepositoryInterface $repository,
        StoreManagerInterface $storeManager,
        Js $jsHelper,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->locatorFactory = $locatorFactory;
        $this->repository = $repository;
        $this->storeManager = $storeManager;
        $this->_jsHelper = $jsHelper;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * @return ResponseInterface|ResultInterface|null
     */
    public function execute()
    {
        if ($data = $this->getRequest()->getPostValue()) {
            try {
                $model = $this->locatorFactory->create();
                if ($locatorId = (int)$this->getRequest()->getParam('locator_id')) {
                    $model = $this->repository->getById($locatorId);
                    if ($locatorId != $model->getId()) {
                        throw new LocalizedException(__('The wrong item is specified.'));
                    }
                }
                if (!$data['is_active']) {
                    $data['is_active'] = 1;
                }
                $model->addData($data);

                // Events
//                $this->_eventManager->dispatch(
//                    'booking_locator_prepare_save',
//                    ['locator' => $model, 'request' => $this->getRequest()]
//                );

                $this->repository->save($model);
                $this->saveService($model, $data);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/edit', ['locator_id' => $model->getId()]);
                }
                return $this->_redirect('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                if ($locatorId = (int)$this->getRequest()->getParam('locator_id')) {
                    $this->_redirect('*/*/edit', ['locator_id' => $locatorId]);
                } else {
                    $this->_redirect('*/*/create');
                }
                return $this->_redirect('*/*/');
            }
        }
    }

    private function saveService($model, $postData)
    {
        if (isset($postData['services'])) {
            $serviceIds = $this->_jsHelper->decodeGridSerializedInput($postData['services']);
            try {
                $newServices = (array) $serviceIds;
                $this->_resources = ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();

                $table = $this->_resources->getTableName('spa_store_service_locator');
                $where = [
                    'locator_id = ?' => (int) $model->getId()
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
