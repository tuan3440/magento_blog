<?php

namespace Dco\Service\Api;

use Dco\Service\Api\Data\LocatorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface LocatorRepositoryInterface
{
    /**
     * Save locator.
     *
     * @param LocatorInterface $locator
     *
     * @throws CouldNotSaveException
     * @return LocatorInterface
     */
    public function save(LocatorInterface $locator);

    /**
     * Retrieve locator.
     *
     * @param int $locatorId
     * @return LocatorInterface
     * @throws NoSuchEntityException
     */
    public function getById($locatorId);

    /**
     * Retrieve locators matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return LocatorInterface[]
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete attachment.
     *
     * @param LocatorInterface $locator
     * @return bool
     * @throws LocalizedException
     */
    public function delete(LocatorInterface $locator);

    /**
     * Delete locator by ID.
     *
     * @param int $locatorId
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($locatorId);
}
