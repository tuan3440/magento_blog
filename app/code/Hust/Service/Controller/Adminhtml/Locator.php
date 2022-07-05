<?php

namespace Hust\Service\Controller\Adminhtml;

use Hust\Service\Model\Repository\LocatorRepository;
use Hust\Service\Model\LocatorFactory;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Backend\Model\Auth\Session;

abstract class Locator extends Action
{
    const ADMIN_RESOURCE = 'Hust_Service::hust_locator';

    protected $resultPageFactory;
    private $locatorFactory;
    private $locatorRepository;
    private $serviceRegistry;
    protected $layoutFactory;
    protected $session;


    public function __construct(
        Context $context,
        Session       $session,
        PageFactory $resultPageFactory,
        LocatorFactory $locatorFactory,
        LocatorRepository $locatorRepository,
        ServiceRegistry $serviceRegistry,
        LayoutFactory $layoutFactory
    )
    {
        $this->session = $session;
        $this->resultPageFactory = $resultPageFactory;
        $this->locatorFactory = $locatorFactory;
        $this->locatorRepository = $locatorRepository;
        $this->serviceRegistry = $serviceRegistry;
        $this->layoutFactory = $layoutFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }

    protected function getLocatorFactory()
    {
        return $this->locatorFactory;
    }

    protected function getLocatorRepository()
    {
        return $this->locatorRepository;
    }

    protected function getServiceRegistry()
    {
        return $this->serviceRegistry;
    }

    protected function checkLocator($locatorCurrent)
    {
        $locatorId = $this->getCurrentUser()->getData('locator_id');
        if ($locatorCurrent) {
            if ($locatorId == $locatorCurrent || $locatorId == 0) return true;
        } else {
            if ($locatorId == 0) {
                return true;
            }
        }

        return false;
    }

    public function getCurrentUser()
    {
        return $this->session->getUser();
    }
}
