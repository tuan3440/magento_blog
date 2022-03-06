<?php

namespace Hust\Service\Block\Service;

use Magento\Framework\View\Element\Template;
use Hust\Service\Model\ResourceModel\Service;
use Hust\Service\Model\ServiceFactory;
use Hust\Service\Model\ResourceModel\Service\CollectionFactory;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Model\LocatorFactory;

class View extends Template
{

    protected $serviceResource;
    protected $serviceFactory;
    protected $serviceCollectionFactory;
    protected $serviceRepository;
    protected $locatorFactory;

    public function __construct(
        Template\Context $context,
        Service $serviceResource,
        ServiceFactory $serviceFactory,
        CollectionFactory $collectionFactory,
        ServiceRepository $serviceRepository,
        LocatorFactory $locatorFactory,
        array $data = []
    ) {
        $this->serviceResource = $serviceResource;
        $this->serviceCollectionFactory = $collectionFactory;
        $this->serviceFactory = $serviceFactory;
        $this->serviceRepository = $serviceRepository;
        $this->locatorFactory = $locatorFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getContentService()
    {
        $id = $this->getRequest()->getParam('id');
        $data = [];
        if ($id) {
              $service = $this->serviceRepository->getById($id);
            $data = [
                'service_id' => $service->getServiceId(),
                'title' => $service->getName(),
                'content' => $service->getContent()
            ];
        }

        return $data;
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
                $data[] = $locatorCurrent;
            }
            return $data;
        }
        return false;
    }

}

