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
use Magento\Customer\Model\SessionFactory;

class View extends Template
{
    protected $locator;
    protected $hours;
    protected $promotion;
    protected $serviceRepo;
    protected $bookingCollection;
    protected $serviceCollection;
    protected $session;
    public function __construct(Template\Context $context,
                                LocatorFactory $locatorFactory,
                                ServiceRepository $serviceRepository,
                                CollectionFactory $bookingCollection,
                                ServiceCollection $serviceCollection,
                                Hour $hours,
                                Promotion $promotion,
                                SessionFactory $session,
                                array $data = [])
    {
        $this->promotion = $promotion;
        $this->locator = $locatorFactory;
        $this->hours = $hours;
        $this->serviceRepo = $serviceRepository;
        $this->bookingCollection = $bookingCollection;
        $this->serviceCollection = $serviceCollection;
        $this->session = $session;
        parent::__construct($context, $data);
    }

    public function getLocator()
    {
        $locator_id = $this->getRequest()->getParam('id');
        $locatorCurrent = $this->locator->create()->load($locator_id);
        return $locatorCurrent;
    }

    public function getCustomerData() {
        $data = [
            'name' => '',
            'gender' => 0,
            'phone' => '',
            'email' => '',
        ];
        if ($customer = $this->isLogin()) {
            $data = [
                'name' => $customer->getName(),
                'gender' => $customer->getData('gender') ? $customer->getData('gender') : 0,
                'phone' => $customer->getData('telephone') ? $customer->getData('telephone') : '',
                'email' => $customer->getEmail() ? $customer->getEmail() : ''
            ];
        }
        return $data;
    }

    public function isLogin()
    {
        return $this->session->create()->getCustomer();
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
        $slots = $this->serviceCollection->create()->getNumberSlot($locatorId, $serviceId);
        $locatorCurrent = $this->locator->create()->load($locatorId);
        $hours = explode(",", $locatorCurrent->getData('hours'));
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
