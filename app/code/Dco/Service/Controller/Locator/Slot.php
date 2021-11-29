<?php
/**
 * Copyright © OpenTechiz, VietNam. All rights reserved.
 * See COPYING.txt for license details.
 * @package        OpenTechiz
 * @author         vuthuan <support@opentechiz.com>
 * @copyright      2021 Vu Thuan (03 2808 3090)
 */

namespace Dco\Service\Controller\Locator;

use Dco\Service\Api\LocatorRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\LayoutFactory;

class Slot  extends Action
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
        $response['slot'] = $layout->createBlock('Dco\Service\Block\Account\InformationCalendar')
            ->setDateBooking($date)
            ->setServiceId($serviceId)
            ->setLocatorId($locatorId)
            ->setTemplate('Dco_Service::hour.phtml')->toHtml();
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($response);
        return $resultJson;
    }
}
