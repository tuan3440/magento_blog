<?php

namespace Dco\Service\Model;

use Dco\Service\Api\Data\LocatorInterface;
use Dco\Service\Api\LocatorRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AbstractAggregateException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class LocatorRepository implements LocatorRepositoryInterface
{
    /**
     * @var LocatorFactory
     */
    private $locatorFactory;

    /**
     * @var ResourceModel\Locator
     */
    private $locatorResource;

    /**
     * @var LocatorInterface[]
     */
    private $locators;

    public function __construct(
        LocatorFactory $locatorFactory,
        ResourceModel\Locator $locatorResource
    ) {
        $this->locatorFactory = $locatorFactory;
        $this->locatorResource = $locatorResource;
    }

    /**
     * @param LocatorInterface $locator
     * @return mixed
     * @throws CouldNotSaveException
     */
    public function save(LocatorInterface $locator)
    {
        try {
            if ($locator->getId()) {
                $locator = $this->getById($locator->getId())->addData($locator->getData());
            }
            $this->locatorResource->save($locator);
            unset($this->locators[$locator->getId()]);
        } catch (\Exception $e) {
            if ($locator->getId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save locator with ID %1. Error: %2',
                        [$locator->getId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new locator. Error: %1', $e->getMessage()));
        }

        return $locator;
    }

    /**
     * @param int $locatorId
     * @return mixed
     */
    public function getById($locatorId)
    {
        if (!isset($this->locators[$locatorId])) {
            $locator = $this->locatorFactory->create();
            $this->locatorResource->load($locator, $locatorId);
            if (!$locator->getId()) {
                throw new NoSuchEntityException(__('Locator with specified ID "%1" not found.', $locatorId));
            }
            $this->locators[$locatorId] = $locator;
        }

        return $this->locators[$locatorId];
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
     * @param LocatorInterface $locator
     * @return mixed
     * @throws CouldNotDeleteException
     */
    public function delete(LocatorInterface $locator)
    {
        try {
            $this->locatorResource->delete($locator);
            unset($this->locators[$locator->getId()]);
        } catch (\Exception $e) {
            if ($locator->getId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove locator with ID %1. Error: %2',
                        [$locator->getId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(__('Unable to remove locator. Error: %1', $e->getMessage()));
        }

        return true;
    }

    /**
     * @param int $locatorId
     * @return mixed
     * @throws NoSuchEntityException|CouldNotDeleteException
     */
    public function deleteById($locatorId)
    {
        if (!($locator = $this->getById($locatorId))) {
            throw new NoSuchEntityException(__('Locator with specified ID "%1" not found.', $locatorId));
        } else {
            $this->delete($locator);

            return true;
        }
    }
}
