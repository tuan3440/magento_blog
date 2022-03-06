<?php

namespace Hust\Service\Controller\Locator;

use Hust\Service\Api\LocatorRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\LayoutFactory;

class Find extends Action
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
        LayoutFactory $layoutFactory
    ) {
        $this->locatorRepository = $locatorRepository;
        $this->layoutFactory = $layoutFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $response = [];
        $layout = $this->layoutFactory->create();
        $service = $this->getRequest()->getParam('service_id', 0);
        $response['stores'] = $layout->createBlock('Hust\Service\Block\Service\View')
            ->setService($service)
            ->setTemplate('Hust_Service::locator/list.phtml')->toHtml();
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($response);
        return $resultJson;
    }
}

