<?php

namespace Hust\Service\Ui\Component\Listing\Columns\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Hust\Service\Model\Repository\ServiceRepository;

class ServiceInfo extends Column
{

    protected $service;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ServiceRepository $serviceRepository,
        array $components = [],
        array $data = []
    ) {
        $this->service = $serviceRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                if (!empty($item[$fieldName])) {
                    $service = $this->service->getById($item[$fieldName]);
                    $info = $service->getName();
                    $item[$fieldName] = $info;
                }
            }
        }
        return $dataSource;
    }
}

