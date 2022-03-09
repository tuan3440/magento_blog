<?php

namespace Hust\Service\Block\Service;

use Hust\Service\Model\Service;
use Magento\Catalog\Model\Product;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Hust\Service\Model\Repository\ServiceRepository;

class RelatedProducts extends Template implements IdentityInterface
{
    private $serviceRepository;
    public function __construct(
        Template\Context $context,
        ServiceRepository $serviceRepository,
        array $data = [])
    {
        $this->serviceRepository = $serviceRepository;
        parent::__construct($context, $data);
    }

    public function getIdentities()
    {
        /** @var \Hust\Service\ViewModel\RelatedProducts $viewModel **/
        $viewModel = $this->getViewModel();

        $currentService = $viewModel->getCurrentService();
        $identities = [Service::CACHE_TAG . '_' . $currentService->getServiceId()];

        return array_reduce($viewModel->getPostProducts(), function (array $carry, Product $product): array {
            return array_merge($carry, $product->getIdentities());
        }, $identities);
    }
}
