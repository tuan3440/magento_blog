<?php

namespace Hust\Service\Model\Repository;

use Hust\Service\Api\PromotionRepositoryInterface;
use Hust\Service\Api\Data\PromotionInterface;
use Hust\Service\Model\ResourceModel\Promotion;
use Hust\Service\Model\PromotionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PromotionRepository implements PromotionRepositoryInterface
{

    private $promotionFactory;
    private $promotionResource;
    private $promotions;

    public function __construct(
        PromotionFactory $promotionFactory,
        Promotion $promotionResource
    )
    {
        $this->promotionFactory = $promotionFactory;
        $this->promotionResource = $promotionResource;
    }


    public function save(PromotionInterface $promotion)
    {
        try {
            if ($promotion->getPromotionId()) {
                $promotion = $this->getById($promotion->getPromotionId())->addData($promotion->getData());
            }
            $this->promotionResource->save($promotion);
            unset($this->promotions[$promotion->getPromotionId()]);
        } catch (\Exception $e) {
            if ($promotion->getPromotionId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save promotion with ID %1. Error: %2',
                        [$promotion->getPromotionId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new promotion. Error: %1', $e->getMessage()));
        }
    }


    public function getById($promotionId)
    {
        if (!isset($this->promotions[$promotionId])) {
            $promotion = $this->promotionFactory->create();
            $this->promotionResource->load($promotion, $promotionId);
            if (!$promotion->getPromotionId()) {
                throw new NoSuchEntityException(__('Promotion with specified ID "%1" not found.', $promotionId));
            }
            $this->promotions[$promotionId] = $promotion;
        }
        return $this->promotions[$promotionId];
    }


    public function delete(PromotionInterface $promotion)
    {
        try {
            $this->promotionResource->delete($promotion);
            unset($this->promotions[$promotion->getPromotionId()]);
        } catch (\Exception $e) {
            if ($promotion->getPromotionId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove promotion with ID %1. Error: %2',
                        [$promotion->getPromotionId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(__('Unable to remove promotion. Error: %1', $e->getMessage()));
        }
        return true;
    }

    public function deleteById($promotionId)
    {
        $promotionModel = $this->getById($promotionId);
        $this->delete($promotionModel);

        return true;
    }

    public function getListPromotion()
    {
        $promotions = $this->promotionFactory->create()->getCollection();
        $promotions->addFieldToFilter('status', 1);
        return $promotions;
    }
}
