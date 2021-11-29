<?php
/**
 * @author ArrowHiTech Team
 * @copyright Copyright (c) 2021 ArrowHiTech (https://www.arrowhitech.com)
 */
namespace Dco\Service\Controller\Adminhtml\Service;

use Dco\Service\Controller\Adminhtml\Service;
use Dco\Service\Model\ServiceRepository;
use Dco\Service\Model\ServiceFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;

class Edit extends Service
{
    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    /**
     * @var ServiceRepository
     */
    private $repository;

    /**
     * @var Registry
     */
    private $registry;

    public function __construct(
        ServiceFactory $serviceFactory,
        ServiceRepository $repository,
        Registry $registry,
        Context $context
    ) {
        parent::__construct($context);
        $this->serviceFactory = $serviceFactory;
        $this->repository = $repository;
        $this->registry = $registry;
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Dco_Service::service');

        if ($serviceId = (int) $this->getRequest()->getParam('service_id')) {
            try {
                $this->repository->getById($serviceId);
                $resultPage->getConfig()->getTitle()->prepend(__('Edit service'));
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This service no longer exists.'));

                return $this->_redirect('*/*/index');
            }
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New service'));
        }

        return $resultPage;
    }
}
