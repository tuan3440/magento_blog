<?php

namespace Dco\Service\Model;

use Dco\Service\Model\ServiceFactory;
use Dco\Service\Api\Data\ServiceInterface;
use Dco\Service\Api\ServiceRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AbstractAggregateException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    /**
     * @var ResourceModel\Service
     */
    private $serviceResource;

    /**
     * @var ServiceInterface[]
     */
    private $services;

    public function __construct(
        ServiceFactory $serviceFactory,
        ResourceModel\Service $serviceResource
    ) {
        $this->serviceFactory = $serviceFactory;
        $this->serviceResource = $serviceResource;
    }

    /**
     * @param ServiceInterface $service
     * @return mixed
     * @throws CouldNotSaveException
     */
    public function save(ServiceInterface $service)
    {
        try {
            if ($service->getServiceId()) {
                $service = $this->getById($service->getServiceId())->addData($service->getData());
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

        return $service;
    }

    /**
     * @param int $serviceId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($serviceId)
    {
        if (!isset($this->services[$serviceId])) {
            $service = $this->serviceFactory->create();
            $this->serviceResource->load($service, $serviceId);
            if (!$service->getserviceId()) {
                throw new NoSuchEntityException(__('Service with specified ID "%1" not found.', $serviceId));
            }
            $this->services[$serviceId] = $service;
        }

        return $this->services[$serviceId];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }

    /**
     * @param ServiceInterface $service
     * @return mixed
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
     * @param int $serviceId
     * @return mixed
     * @throws NoSuchEntityException|CouldNotDeleteException
     */
    public function deleteById($serviceId)
    {
        if (!($service = $this->getById($serviceId))) {
            throw new NoSuchEntityException(__('Service with specified ID "%1" not found.', $serviceId));
        } else {
            $this->delete($service);

            return true;
        }
    }
}
