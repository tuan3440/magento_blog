<?php

namespace Dco\Service\Ui\Component\Listing\Columns\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use \Dco\Service\Model\System\UrlResolver;
use Magento\Customer\Model\CustomerFactory;

class CustomerInfo extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var UrlResolver
     */
    protected $urlResolver;
    protected $customer;
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
        CustomerFactory $customerFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->urlResolver = $urlResolver;
        $this->customer = $customerFactory;
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
                    $customer = $this->customer->create()->load($item[$fieldName]);
                    $info = htmlspecialchars_decode($customer->getName(). ' <br/>sdt : ' . $customer->getDefaultShippingAddress()->getTelephone());
                    $item[$fieldName] = $info;
                }
            }
        }
        return $dataSource;
    }
}
