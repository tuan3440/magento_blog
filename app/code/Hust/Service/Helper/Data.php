<?php

namespace Hust\Service\Helper;

use Amasty\Blog\Model\ResourceModel\Posts\RelatedProducts\GetPostRelatedProducts;
use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Helper\Image;

class Data extends AbstractHelper
{
    public $productRepository;
    private $imageProvider;

   public function __construct(
       Context $context,
       ProductRepository $productRepository,
       Image $imageProvider
   )
   {
       $this->productRepository = $productRepository;
       $this->imageProvider = $imageProvider;
       parent::__construct($context);
   }

   public function getRelatedProductData($items)
   {
       $data = [];
       if ($items) {
           foreach ($items as $item) {
               $data[] = $this->getProductData($item);
           }
       }
       return $data;
   }

    public function getRelatedProductAllData($items)
    {
        $data = [];
        if ($items) {
            foreach ($items as $item) {
                $data[] = $this->getProductAllData($item);
            }
        }
        return $data;
    }

   public function getProductData($item)
   {
       $product = $this->productRepository->getById($item['product_id']);
       return [
           'entity_id' => $product->getId(),
           'amasty_blog_position' => $item['position'],
           'websites' => join(',', (array)$product->getWebsiteIds()),
           'name' => $product->getName(),
           'visibility' => $product->getVisibility(),
           'status' => $product->getStatus(),
           'thumbnail' => $this->imageProvider->init($product, 'product_listing_thumbnail')->getUrl()
       ];
   }

   public function getProductAllData($item)
   {
       return $this->productRepository->getById($item['product_id']);
   }
}
