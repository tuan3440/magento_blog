<?php

namespace Dco\Service\Api;

use Dco\Service\Api\Data\ServiceInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface ServiceRepositoryInterface
{
    /**
     * Save service.
     *
     * @param ServiceInterface $service
     *
     * @throws CouldNotSaveException
     * @return ServiceInterface
     */
    public function save(ServiceInterface $service);

    /**
     * Retrieve service.
     *
     * @param int $serviceId
     * @return ServiceInterface
     * @throws NoSuchEntityException
     */
    public function getById($serviceId);

    /**
     * Retrieve services matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ServiceInterface[]
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete attachment.
     *
     * @param ServiceInterface $service
     * @return bool
     * @throws LocalizedException
     */
    public function delete(ServiceInterface $service);

    /**
     * Delete service by ID.
     *
     * @param int $serviceId
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($serviceId);
}
