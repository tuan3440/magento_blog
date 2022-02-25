<?php

namespace Hust\Service\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Hust\Service\Model\ServiceFactory;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Model\ServiceRegistry;

abstract class Service extends Action
{
    const ADMIN_RESOURCE = 'Hust_Service::hust_service';

    protected $resultPageFactory;
    private $serviceFactory;
    private $serviceRepository;
    private $serviceRegistry;


    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ServiceFactory $serviceFactory,
        ServiceRepository $serviceRepository,
        ServiceRegistry $serviceRegistry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->serviceFactory = $serviceFactory;
        $this->serviceRepository = $serviceRepository;
        $this->serviceRegistry = $serviceRegistry;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }

    protected function getServiceFactory()
    {
        return $this->serviceFactory;
    }

    protected function getServiceRepository()
    {
        return $this->serviceRepository;
    }

    protected function getServiceRegistry()
    {
        return $this->serviceRegistry;
    }


}
