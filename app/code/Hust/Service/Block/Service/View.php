<?php

namespace Hust\Service\Block\Service;

use Hust\Service\Model\System\UrlResolver;
use Magento\Framework\View\Element\Template;
use Hust\Service\Model\ResourceModel\Service;
use Hust\Service\Model\ServiceFactory;
use Hust\Service\Model\ResourceModel\Service\CollectionFactory;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Model\LocatorFactory;
use Hust\Service\Model\ResourceModel\Review;
class View extends Template
{
    protected $review;
    protected $serviceResource;
    protected $serviceFactory;
    protected $serviceCollectionFactory;
    protected $serviceRepository;
    protected $locatorFactory;
    /**
     * @var UrlResolver
     */
    protected $urlResolver;

    public function __construct(
        Template\Context $context,
        Service $serviceResource,
        ServiceFactory $serviceFactory,
        CollectionFactory $collectionFactory,
        ServiceRepository $serviceRepository,
        LocatorFactory $locatorFactory,
        UrlResolver $urlResolver,
        Review $review,
        array $data = []
    ) {
        $this->serviceResource = $serviceResource;
        $this->serviceCollectionFactory = $collectionFactory;
        $this->serviceFactory = $serviceFactory;
        $this->serviceRepository = $serviceRepository;
        $this->locatorFactory = $locatorFactory;
        $this->urlResolver = $urlResolver;
        $this->review = $review;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getContentService()
    {
        $id = $this->getRequest()->getParam('id');
        $point = $this->review->getPointService($id);
        $data = [];
        if ($id) {
              $service = $this->serviceRepository->getById($id);
            $data = [
                'service_id' => $service->getServiceId(),
                'title' => $service->getName(),
                'content' => $service->getContent(),
                'image' => $this->getMediaImage($service->getImage()),
                'point' => round($point[0]['avg'])
            ];
        }

        return $data;
    }

    public function getContentServiceReview()
    {
        $id = $this->getRequest()->getParam('service_id');
        $point = $this->review->getPointService($id);
        $data = [];
        if ($id) {
            $service = $this->serviceRepository->getById($id);
            $data = [
                'service_id' => $service->getServiceId(),
                'title' => $service->getName(),
                'content' => $service->getContent(),
                'image' => $this->getMediaImage($service->getImage()),
                'point' => round($point[0]['avg'])
            ];
        }

        return $data;
    }

    private function getMediaImage($name)
    {
        return $this->urlResolver->getImageUrlByName($name);
    }

    public function getExistsLocator()
    {
        $data = [];
        $serviceId = $this->getService();
        $locator = $this->locatorFactory->create();
        if ($list = $locator->getLocatorInService($serviceId)) {
            foreach ($list as $id) {
                $locator = $this->locatorFactory->create();
                $locatorCurrent = $locator->load($id);
                if ($locator->getIsActive() == 1) $data[] = $locatorCurrent;

            }
            return $data;
        }
        return false;
    }

    public function getDataReview()
    {
        $service_id = $this->getRequest()->getParam('service_id');
        $idbookingSale = $this->getRequest()->getParam('id');
        return [
            'service_id' => $service_id,
            "bookingSale" => $idbookingSale
        ];
    }

}

