<?php

namespace Hust\Service\Model\DataProvider\Service;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Hust\Service\Model\ResourceModel\Service\CollectionFactory;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Model\System\UrlResolver;

class Form extends AbstractDataProvider
{
    protected $collection;
    protected $serviceRepository;
    private $urlResolver;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        ServiceRepository $serviceRepository,
        UrlResolver $urlResolver,
        array $meta = [],
        array $data = [])
    {
        $this->collection = $collectionFactory->create();
        $this->serviceRepository = $serviceRepository;
        $this->urlResolver = $urlResolver;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $data = parent::getData();
        if ($data['totalRecords'] > 0) {
            $serviceId = (int)$data['items'][0]['service_id'];
            $model = $this->getService($serviceId);
            if ($model) {
                $serviceData = $model->getData();
                $serviceData['image'] = [
                    [
                        'name' => $model->getImage(),
                        'url' => $this->urlResolver->getImageUrlByName($model->getImage())
                    ]
                ];
                $data[$model->getServiceId()] = $serviceData;
            }
        }
        return $data;
    }

    private function getService($serviceId)
    {
        try {
            $model = $this->serviceRepository->getById($serviceId);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $model = null;
        }

        return $model;
    }
}
