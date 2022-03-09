<?php

namespace Hust\Service\ViewModel;

use Amasty\Blog\Api\Data\GetPostRelatedProductsInterface;
use Amasty\Blog\Api\Data\PostInterface;
use Hust\Service\Model\ServiceRegistry;
use Amasty\Blog\Model\ConfigProvider;
use Magento\Catalog\Block\Product\ImageFactory;
use Magento\Catalog\Block\Product\ReviewRendererInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\Framework\Pricing\Render;
use Magento\Framework\Pricing\Render as PriceRender;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\LayoutInterface;
use Hust\Service\Model\ResourceModel\Service;
use Hust\Service\Helper\Data;

class RelatedProducts implements ArgumentInterface
{
    private const IMAGE_ID = 'amasty_blog_related_products_thumbnail';
    private const CURRENT_SERVICE = 'current_service';
    private $registry;


    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var ImageFactory
     */
    private $imageFactory;

    /**
     * @var ReviewRendererInterface
     */
    private $reviewRenderer;

    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * @var PriceRender
     */
    private $priceRenderer;

    /**
     * @var ProductsList
     */
    private $productList;

    /**
     * @var SerializerInterface
     */
    private $serializer;
    private $resourceService;
    private $helper;

    public function __construct(
        ServiceRegistry $registry,
        ConfigProvider $configProvider,
        ImageFactory $imageFactory,
        ReviewRendererInterface $reviewRenderer,
        LayoutInterface $layout,
        ProductsList $productList,
        SerializerInterface $serializer,
        Service $resourceService,
        Data $helper
    ) {
        $this->registry = $registry;
        $this->configProvider = $configProvider;
        $this->imageFactory = $imageFactory;
        $this->reviewRenderer = $reviewRenderer;
        $this->layout = $layout;
        $this->productList = $productList;
        $this->serializer = $serializer;
        $this->resourceService = $resourceService;
        $this->helper = $helper;
    }

    public function getCurrentService()
    {
        return $this->registry->registry(self::CURRENT_SERVICE);
    }

    public function getPostProducts()
    {
        $service = $this->getCurrentService();
        $relatedProducts = $this->resourceService->getRelatedProduct($service->getServiceId());
        $data = $this->helper->getRelatedProductAllData($relatedProducts);
        return $data;
    }

    /**
     * @return string
     */
    public function getRelatedProductsBlockName(): string
    {
        return $this->configProvider->getPostPageBlockTitleOnPostPage();
    }

    /**
     * @return bool
     */
    public function isCanRender(): bool
    {
        return count($this->getPostProducts()) > 0;
    }

    /**
     * @param Product $product
     * @return string|null
     */
    public function getImageHtml(Product $product): ?string
    {
        return $this->imageFactory->create($product, self::IMAGE_ID, [])->toHtml();
    }

    /**
     * @param Product $product
     * @return string|null
     */
    public function getReviewsHtml(Product $product): ?string
    {
        return $this->reviewRenderer->getReviewsSummaryHtml($product, ReviewRendererInterface::SHORT_VIEW);
    }

    /**
     * @return PriceRender
     */
    private function getPriceRenderer(): PriceRender
    {
        if (!$this->priceRenderer) {
            $this->priceRenderer = $this->layout->createBlock(
                PriceRender::class,
                '',
                ['data' => [
                    'price_render_handle' => 'catalog_product_prices',
                    'include_container' => true,
                    'display_minimal_price' => true,
                    'zone' => Render::ZONE_ITEM_LIST,
                    'list_category_page' => true
                ]]
            );
        }

        return $this->priceRenderer;
    }

    /**
     * @param Product $product
     * @return string|null
     */
    public function getProductPriceHtml(Product $product): ?string
    {
        return $this->getPriceRenderer()->render(FinalPrice::PRICE_CODE, $product);
    }

    /**
     * @param $product
     * @return string
     */
    public function getAddToCartPostParams($product): string
    {
        return $this->serializer->serialize($this->productList->getAddToCartPostParams($product));
    }
}
