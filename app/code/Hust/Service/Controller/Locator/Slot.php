<?php

namespace Hust\Service\Controller\Locator;

use Hust\Service\Api\LocatorRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\LayoutFactory;
class Slot extends Action
{
    /**
     * @var LocatorRepositoryInterface
     */
    protected $locatorRepository;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;

    /**
     * Find constructor.
     * @param Context $context
     * @param LocatorRepositoryInterface $locatorRepository
     * @param ProductFactory $productFactory
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        Context $context,
        LocatorRepositoryInterface $locatorRepository,
        ProductFactory $productFactory,
        LayoutFactory $layoutFactory
    ) {
        $this->locatorRepository = $locatorRepository;
        $this->productFactory = $productFactory;
        $this->layoutFactory = $layoutFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $response = [];
        $layout = $this->layoutFactory->create();
        $date = $this->getRequest()->getParam('date', 0);
        $serviceId = $this->getRequest()->getParam('service_id', 0);
        $locatorId = $this->getRequest()->getParam('locator_id', 0);
        $response['slot'] = $layout->createBlock('Hust\Service\Block\Locator\View')
            ->setDateBooking($date)
            ->setServiceIdCurrent($serviceId)
            ->setLocatorIdCurrent($locatorId)
            ->setTemplate('Hust_Service::hour.phtml')->toHtml();
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($response);
        return $resultJson;
    }
}
