<?php

namespace Dco\Service\Ui\Component\Listing\Columns\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use \Dco\Service\Model\System\UrlResolver;
use Dco\Service\Model\ServiceFactory;

class ServiceInfo extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var UrlResolver
     */
    protected $urlResolver;
    protected $service;
    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param UrlResolver $urlResolver
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        UrlResolver $urlResolver,
        ServiceFactory $serviceFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->urlResolver = $urlResolver;
        $this->service = $serviceFactory;
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
                    $service = $this->service->create()->load($item[$fieldName]);
                    $info = $service->getName();
                    $item[$fieldName] = $info;
                }
            }
        }
        return $dataSource;
    }
}
