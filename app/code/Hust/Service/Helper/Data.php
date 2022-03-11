<?php

namespace Hust\Service\Helper;

use Amasty\Blog\Model\ResourceModel\Posts\RelatedProducts\GetPostRelatedProducts;
use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Helper\Image;
use Hust\Service\Model\Repository\EmployeeRepository;
use Hust\Service\Model\ResourceModel\Booking;

class Data extends AbstractHelper
{
    public $productRepository;
    private $imageProvider;
    private $employeeRepo;
    private $bookingRepo;

   public function __construct(
       Context $context,
       ProductRepository $productRepository,
       EmployeeRepository $employeeRepo,
       Image $imageProvider,
       Booking $bookingRepo
   )
   {
       $this->productRepository = $productRepository;
       $this->imageProvider = $imageProvider;
       $this->employeeRepo = $employeeRepo;
       $this->bookingRepo = $bookingRepo;
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

   public function getListEmployeeAvailable()
   {
       $employees = $this->employeeRepo->getListEmployee()->getItems();
       $data = [];
       $data[''] = __('Select employee');

       foreach ($employees as $employee) {
           $data[$employee->getData('employee_id')] = __($employee->getData('first_name') . ' ' . $employee->getData('last_name'));
       }
       return $data;
   }

   public function getEmployeeOfBooking($bookingId)
   {
       return $this->bookingRepo->getEmployeeBooking($bookingId);
   }
}
