<?php
/**
 * @author ArrowHiTech Team
 * @copyright Copyright (c) 2021 ArrowHiTech (https://www.arrowhitech.com)
 */
namespace Dco\Service\Controller\Adminhtml\Service;

use Dco\Service\Api\ServiceRepositoryInterface;
use Dco\Service\Controller\Adminhtml\Service;
use Dco\Service\Model\ServiceFactory as ServiceFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;

class Save extends Service
{
    /**
     * @var ServiceRepositoryInterface
     */
    private $repository;

    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Context $context,
        ServiceFactory $serviceFactory,
        ServiceRepositoryInterface $repository,
        StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->serviceFactory = $serviceFactory;
        $this->repository = $repository;
        $this->storeManager = $storeManager;
        $this->dataPersistor = $dataPersistor;
    }

    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                $model = $this->serviceFactory->create();
                $data = $this->getRequest()->getPostValue();

                if ($serviceId = (int)$this->getRequest()->getParam('service_id')) {
                    $model = $this->repository->getById($serviceId);
                    if ($serviceId != $model->getserviceId()) {
                        throw new LocalizedException(__('The wrong item is specified.'));
                    }
                }

                $this->filterData($data);
                $model->addData($data);
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['service_id' => $model->getId()]);
                    return;
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->dataPersistor->set('service_data', $data);
                if ($serviceId = (int)$this->getRequest()->getParam('service_id')) {
                    $this->_redirect('*/*/edit', ['service_id' => $serviceId]);
                } else {
                    $this->_redirect('*/*/create');
                }
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * @param array $data
     */
    private function filterData(&$data)
    {
        if (isset($data['imagefile']) && is_array($data['imagefile'])) {
            if (isset($data['imagefile'][0]['name'])
                && isset($data['imagefile'][0]['tmp_name'])
            ) {
                $data['image'] = $data['imagefile'][0]['file'];
            }
        } else {
            $data['image'] = '';
        }
    }
}
