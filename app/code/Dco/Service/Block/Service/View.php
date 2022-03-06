<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Block\Service;

//use Dco\Service\Helper\ScopeConfig;
use Dco\Service\Model\LocatorFactory;
use Dco\Service\Model\ResourceModel\Locator\CollectionFactory as LocatorCollectionFactory;
use Dco\Service\Model\Service;
use Dco\Service\Model\ServiceFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;

/**
 * Class View
 * @package Dco\Service\Block\Service
 */
class View extends Template
{

    /**
     * @var ServiceFactory
     */
    protected $serviceFactory;

    /**
     * @var LocatorFactory
     */
    protected $locatorFactory;

    /**
     * @var LocatorCollectionFactory
     */
    protected $locatorCollectionFactory;


    /**
     * View constructor.
     * @param Template\Context $context
     * @param LocatorCollectionFactory $collectionFactory
     * @param LocatorFactory $locatorFactory
     * @param ServiceFactory $serviceFactory

     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        LocatorCollectionFactory $collectionFactory,
        LocatorFactory $locatorFactory,
        ServiceFactory $serviceFactory,
        array $data = []
    ) {
        $this->locatorFactory = $locatorFactory;
        $this->locatorCollectionFactory = $collectionFactory;
        $this->serviceFactory = $serviceFactory;
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
            $service = $this->serviceFactory->create()->load($id);
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


//    public function getIdentities()
//    {
//        return [Service::CACHE_TAG . '_' . 'detail'];
//    }


}
