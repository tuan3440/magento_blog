<?php

namespace Hust\Service\Model\DataProvider\Promotion;

use Hust\Service\Helper\Data;
use Hust\Service\Model\Repository\PromotionRepository;
use Hust\Service\Model\ResourceModel\Promotion\CollectionFactory;
use Hust\Service\Model\ResourceModel\Promotion;
use Hust\Service\Model\System\UrlResolver;
use Magento\Ui\DataProvider\AbstractDataProvider;

class Form extends AbstractDataProvider
{
    protected $collection;
    protected $promotionRepository;
    private $promotionResource;
    private $urlResolver;
    private $helperData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        PromotionRepository $promotionRepository,
        UrlResolver $urlResolver,
        Promotion $promotionResource,
        array $meta = [],
        array $data = [])
    {
        $this->collection = $collectionFactory->create();
        $this->promotionRepository = $promotionRepository;
        $this->urlResolver = $urlResolver;
        $this->serviceResource = $promotionResource;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $data = parent::getData();
        if ($data['totalRecords'] > 0) {
            $promotionId = (int)$data['items'][0]['promotion_id'];
            $model = $this->getPromotion($promotionId);
            if ($model) {
                $promotionData = $model->getData();
                $promotionData['image'] = [
                    [
                        'name' => $model->getImage(),
                        'url' => $this->urlResolver->getImageUrlByName($model->getImage())
                    ]
                ];
                $data[$model->getPromotionId()] = $promotionData;
            }
        }
        return $data;
    }

    private function getPromotion($promotionId)
    {
        try {
            $model = $this->promotionRepository->getById($promotionId);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $model = null;
        }

        return $model;
    }

}

