<?php

namespace Hust\Service\Block\Locator;

use Magento\Framework\View\Element\Template;
use Hust\Service\Model\LocatorFactory;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Model\Source\Hour;
use Hust\Service\Model\Repository\PromotionRepository;
use Hust\Service\Model\ResourceModel\Promotion;

class View extends Template
{
    protected $locator;
    protected $hours;
    protected $promotion;
    protected $serviceRepo;
    public function __construct(Template\Context $context,
                                LocatorFactory $locatorFactory,
                                ServiceRepository $serviceRepository,
                                Hour $hours,
                                Promotion $promotion,
                                array $data = [])
    {
        $this->promotion = $promotion;
        $this->locator = $locatorFactory;
        $this->hours = $hours;
        $this->serviceRepo = $serviceRepository;
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
        return $this->hours->toArray();
    }

    public function getCharge()
    {
        $serviceId = $this->getServiceId();
        $service = $this->serviceRepo->getById($serviceId);
        $charge = $service->getCharge();
        $discount = $this->promotion->getDiscountByPromotion($serviceId);
        return (int)$charge*$discount;

    }
}
