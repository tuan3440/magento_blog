<?php

namespace Hust\Service\Ui\Component\Listing\Columns\Column;

use Hust\Service\Model\Repository\LocatorRepository;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class LocatorInfo extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;


    protected $locator;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        LocatorRepository $locatorRepo,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->locator = $locatorRepo;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                if (!empty($item[$fieldName])) {
                    $locator = $this->locator->getById($item[$fieldName]);
                    $info = $locator->getName();
                    $item[$fieldName] = $info;
                }
            }
        }
        return $dataSource;
    }
}

