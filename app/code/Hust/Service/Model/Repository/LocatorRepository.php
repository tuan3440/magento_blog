<?php

namespace Hust\Service\Model\Repository;

use Hust\Service\Api\LocatorRepositoryInterface;
use Hust\Service\Api\Data\LocatorInterface;
use Hust\Service\Model\ResourceModel\Locator;
use Hust\Service\Model\LocatorFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class LocatorRepository implements LocatorRepositoryInterface
{
    private $locatorFactory;
    private $locatorResource;
    private $locators;

    public function __construct(
        LocatorFactory $locatorFactory,
        Locator $locatorResource
    )
    {
        $this->locatorFactory = $locatorFactory;
        $this->locatorResource = $locatorResource;
    }

    /**
     * @param LocatorInterface $locator
     * @return void
     * @throws CouldNotSaveException
     */
    public function save(LocatorInterface $locator)
    {
        try {
            if ($locator->getLocatorId()) {
                $locator = $this->getById($locator->getLocatorId())->addData($locator->getData());
            } else {
                $locator->getLocatorId(null);
            }
            $this->locatorResource->save($locator);
            unset($this->locators[$locator->getLocatorId()]);
        } catch (\Exception $e) {
            if ($locator->getLocatorId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save locator with ID %1. Error: %2',
                        [$locator->getLocatorId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new service. Error: %1', $e->getMessage()));
        }
    }

    /**
     * @param $locatorId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($locatorId)
    {
        if (!isset($this->locators[$locatorId])) {
            $locators = $this->locatorFactory->create();
            $this->locatorResource->load($locators, $locatorId);
            if (!$locators->getLocatorId()) {
                throw new NoSuchEntityException(__('Service with specified ID "%1" not found.', $locatorId));
            }
            $this->locators[$locatorId] = $locators;
        }
        return $this->locators[$locatorId];
    }

    /**
     * @param LocatorInterface $locator
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(LocatorInterface $locator)
    {
        try {
            $this->locatorResource->delete($locator);
            unset($this->locators[$locator->getLocatorId()]);
        } catch (\Exception $e) {
            if ($locator->getLocatorId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove service with ID %1. Error: %2',
                        [$locator->getLocatorId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(__('Unable to remove service. Error: %1', $e->getMessage()));
        }
        return true;
    }

    /**
     * @param $locatorId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($locatorId)
    {
        $locatorModel = $this->getById($locatorId);
        $this->delete($locatorModel);

        return true;
    }

    public function getListLocator()
    {
        $locators = $this->locatorFactory->create()->getCollection();
        $locators->addFieldToFilter('is_active', 1);
        return $locators;
    }
}
