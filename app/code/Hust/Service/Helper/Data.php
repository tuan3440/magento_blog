<?php

namespace Hust\Service\Helper;

use Amasty\Blog\Model\ResourceModel\Posts\RelatedProducts\GetPostRelatedProducts;
use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Helper\Image;
use Hust\Service\Model\Repository\EmployeeRepository;
use Hust\Service\Model\ResourceModel\Booking;
use Hust\Service\Model\ResourceModel\Employee;

class Data extends AbstractHelper
{
    public $productRepository;
    private $imageProvider;
    private $employeeRepo;
    private $bookingResource;
    private $employeeResource;
   public function __construct(
       Context $context,
       ProductRepository $productRepository,
       EmployeeRepository $employeeRepo,
       Image $imageProvider,
       Booking $bookingResource,
       Employee $employeeResource
   )
   {
       $this->productRepository = $productRepository;
       $this->imageProvider = $imageProvider;
       $this->employeeRepo = $employeeRepo;
       $this->bookingResource = $bookingResource;
       $this->employeeResource = $employeeResource;
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

    public function getListEmployeeAvailable($locatorId, $serviceId, $booking_hour, $date)
    {
        $employees = $this->employeeResource->getEmployeeOfLocatorAndService($locatorId, $serviceId);
        $data = [];
        $data[''] = __('Select employee');
        $employeeNotAvailable = $this->bookingResource->getEmployeeNotAvailable($locatorId, $serviceId, $booking_hour, $date);
        foreach ($employees as $employee) {
            if (!in_array($employee['employee_id'], $employeeNotAvailable))
            $data[$employee['employee_id']] = __($employee['first_name'] . ' ' . $employee['last_name']);
        }
        return $data;
    }

   public function getEmployeeOfBooking($bookingId)
   {
       return $this->bookingResource->getEmployeeBooking($bookingId);
   }
}
