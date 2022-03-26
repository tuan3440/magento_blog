<?php

namespace Hust\Service\Model\Repository;

use Hust\Service\Api\ServiceRepositoryInterface;
use Hust\Service\Api\Data\ServiceInterface;
use Hust\Service\Model\ResourceModel\Service;
use Hust\Service\Model\ServiceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * @var ServiceFactory
     */
    private $serviceFactory;
    /**
     * @var Service
     */
    private $serviceResource;
    /**
     * @var array
     */
    private $services;

    public function __construct(
        ServiceFactory $serviceFactory,
        Service $serviceResource
    )
    {
        $this->serviceFactory = $serviceFactory;
        $this->serviceResource = $serviceResource;
    }

    /**
     * @param ServiceInterface $service
     * @return void
     * @throws CouldNotSaveException
     */
    public function save(ServiceInterface $service)
    {
        try {
            if ($service->getServiceId()) {
                $service = $this->getById($service->getServiceId())->addData($service->getData());
            } else {
                $service->setServiceId(null);
            }
            $this->serviceResource->save($service);
            unset($this->services[$service->getServiceId()]);
        } catch (\Exception $e) {
            if ($service->getServiceId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save service with ID %1. Error: %2',
                        [$service->getServiceId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new service. Error: %1', $e->getMessage()));
        }
    }

    /**
     * @param $serviceId
     * @return \Hust\Service\Model\Service|mixed
     * @throws NoSuchEntityException
     */
    public function getById($serviceId)
    {
        if (!isset($this->services[$serviceId])) {
            $service = $this->serviceFactory->create();
            $this->serviceResource->load($service, $serviceId);
            if (!$service->getServiceId()) {
                throw new NoSuchEntityException(__('Service with specified ID "%1" not found.', $serviceId));
            }
            $this->services[$serviceId] = $service;
        }
        return $this->services[$serviceId];
    }

    /**
     * @param ServiceInterface $service
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ServiceInterface $service)
    {
        try {
            $this->serviceResource->delete($service);
            unset($this->services[$service->getServiceId()]);
        } catch (\Exception $e) {
            if ($service->getServiceId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove service with ID %1. Error: %2',
                        [$service->getServiceId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(__('Unable to remove service. Error: %1', $e->getMessage()));
        }
        return true;
    }

    /**
     * @param $serviceId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($serviceId)
    {
        $serviceModel = $this->getById($serviceId);
        $this->delete($serviceModel);

        return true;
    }

    public function getListService()
    {
       $services = $this->serviceFactory->create()->getCollection();
       $services->addFieldToFilter('is_active', 1);
       return $services;
    }
}
