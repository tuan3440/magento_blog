<?php

namespace Hust\Service\Ui\Component\Listing\Columns\Column;

use Hust\Service\Model\Repository\EmployeeRepository;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class EmployeeInfo extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;


    protected $employee;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        EmployeeRepository $employee,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->employee = $employee;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                if (!empty($item[$fieldName])) {
                    $locator = $this->employee->getById($item[$fieldName]);
                    $info = $locator->getFirstName().' '.$locator->getLastName();
                    $item[$fieldName] = $info;
                }
            }
        }
        return $dataSource;
    }
}


