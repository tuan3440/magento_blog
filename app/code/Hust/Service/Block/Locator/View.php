<?php

namespace Hust\Service\Block\Locator;

use Magento\Framework\View\Element\Template;
use Hust\Service\Model\LocatorFactory;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Model\Source\Hour;
use Hust\Service\Model\Repository\PromotionRepository;
use Hust\Service\Model\ResourceModel\Promotion;
use Hust\Service\Model\ResourceModel\Booking\CollectionFactory;
use Hust\Service\Model\ResourceModel\Service\CollectionFactory as ServiceCollection;

class View extends Template
{
    protected $locator;
    protected $hours;
    protected $promotion;
    protected $serviceRepo;
    protected $bookingCollection;
    protected $serviceCollection;

    public function __construct(Template\Context $context,
                                LocatorFactory $locatorFactory,
                                ServiceRepository $serviceRepository,
                                CollectionFactory $bookingCollection,
                                ServiceCollection $serviceCollection,
                                Hour $hours,
                                Promotion $promotion,
                                array $data = [])
    {
        $this->promotion = $promotion;
        $this->locator = $locatorFactory;
        $this->hours = $hours;
        $this->serviceRepo = $serviceRepository;
        $this->bookingCollection = $bookingCollection;
        $this->serviceCollection = $serviceCollection;
        parent::__construct($context, $data);
    }

    public function getLocator()
    {
        $locator_id = $this->getRequest()->getParam('id');
        $locatorCurrent = $this->locator->create()->load($locator_id);
        return $locatorCurrent;
    }



    public function getServiceId()
    {
        return $this->getRequest()->getParam('service');
    }

    public function getHours()
    {
        $hoursList = [];
        $locatorId = $this->getLocatorIdCurrent();
        $serviceId = $this->getServiceIdCurrent();
        $service = $this->serviceRepo->getById($serviceId);
        $slots = $this->serviceCollection->create()->getNumberSlot($locatorId, $serviceId);
        if ($service->getData('type_service_time') == 0) {
            $hours = [0 ,1, 2, 3, 4, 5, 6, 7];
        } elseif ($service->getData('type_service_time') == 2) {
            $hours = [24 , 25, 26, 27];
        } else {
            $hours = [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
        }
        $hourList = $this->hours->toArray();
        foreach ($hourList as $key => $value) {
            if (in_array($key, $hours)) {
                $hoursList[$key] = [
                     'value' => $value,
                     'slot' => $slots,
//                     'isAvailable' => 1
                ];
            }
        }
        return $hoursList;
    }

    public function getCharge()
    {
        $serviceId = $this->getServiceId();
        $service = $this->serviceRepo->getById($serviceId);
        $charge = $service->getCharge();
        $discount = $this->promotion->getDiscountByPromotion($serviceId);
        return (int)$charge*$discount;

    }

    public function getSlot()
    {
        $slots = [];
        $hours = $this->getHours();
        $serviceId = $this->getServiceIdCurrent();
        $locatorId = $this->getLocatorIdCurrent();
        $date = $this->getDateBooking();
        $collection = $this->bookingCollection->create()->addFieldToFilter("booking_status", ['in' => [0, 1]])
            ->addFieldToFilter('service_id', $serviceId)
            ->addFieldToFilter('date', $date)
            ->addFieldToFilter('locator_id', $locatorId);
        if ($collection->getItems() > 0) {
            foreach ($collection->getItems() as $c) {
                $slots[] = $c['booking_hour'];
            }
        }

        foreach ($hours as $key => $value) {
            if (in_array($key, $slots)) {
                $hours[$key]['slot'] = $hours[$key]['slot'] - 1;
            }
        }
        return $hours;
    }
}
