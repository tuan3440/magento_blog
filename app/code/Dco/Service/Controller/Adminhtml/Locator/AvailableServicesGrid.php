<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Controller\Adminhtml\Locator;

use Dco\Service\Controller\Adminhtml\Service;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory;

class AvailableServicesGrid extends Service
{
    /**
     * @var LayoutFactory
     */
    protected $resultLayoutFactory;

    public function __construct(
        Context $context,
        LayoutFactory $resultLayoutFactory
    ) {
        parent::__construct($context);
        $this->resultLayoutFactory = $resultLayoutFactory;
    }

    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('booking.locator.edit.tab.availableservices')
            ->setInServices($this->getRequest()->getPost('locator_services'));
        return $resultLayout;
    }
}
