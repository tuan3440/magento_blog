<?php

namespace Hust\Service\Model\DataProvider\Employee;

use Hust\Service\Model\Repository\EmployeeRepository;
use Hust\Service\Model\ResourceModel\Employee\CollectionFactory;
use Hust\Service\Model\System\UrlResolver;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\ResourceConnection;

class Form extends AbstractDataProvider
{
    protected $collection;
    protected $employeeRepository;
    private $urlResolver;
    private $resource;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        EmployeeRepository $employeeRepository,
        UrlResolver $urlResolver,
        ResourceConnection $resourceConnection,
        array $meta = [],
        array $data = [])
    {
        $this->collection = $collectionFactory->create();
        $this->employeeRepository = $employeeRepository;
        $this->urlResolver = $urlResolver;
        $this->resource = $resourceConnection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $data = parent::getData();
        if ($data['totalRecords'] > 0) {
            $employeeId = (int)$data['items'][0]['employee_id'];
            $model = $this->getEmployee($employeeId);
            $services = $this->getServices($employeeId);
            $locator = $this->getLocator($employeeId);
            if ($model) {
                $employeeData = $model->getData();
                $employeeData['image'] = [
                    [
                        'name' => $model->getImage(),
                        'url' => $this->urlResolver->getImageUrlByName($model->getImage())
                    ]
                ];
                $employeeData['service_id'] = $services;
                $employeeData['locator_id'] = $locator;
                $data[$model->getEmployeeId()] = $employeeData;
            }
        }
        return $data;
    }

    private function getEmployee($employeeId)
    {
        try {
            $model = $this->employeeRepository->getById($employeeId);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $model = null;
        }

        return $model;
    }

    private function getServices($employeeId)
    {
        $array = [];
        $connection = $this->resource->getConnection();
        $table = $connection->getTableName('hust_employee_service');
        $sql = "Select * FROM ".$table." where employee_id=".$employeeId;
        $result = $connection->fetchAll($sql);
        if ($result) {
            foreach ($result as $r) {
                $array[] = $r['service_id'];
            }
        }
        return implode(',', $array);
    }

    private function getLocator($employeeId)
    {
        $locator = null;
        $connection = $this->resource->getConnection();
        $table = $connection->getTableName('hust_employee_locator');
        $sql = "Select * FROM ".$table." where employee_id=".$employeeId;
        $result = $connection->fetchAll($sql);
        if ($result) {
            $locator = $result[0]['locator_id'];
        }
        return $locator;
    }
}

