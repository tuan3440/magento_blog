<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Controller\Adminhtml\Locator;

use Dco\Service\Controller\Adminhtml\Locator;
use Dco\Service\Model\LocatorFactory;
use Dco\Service\Model\LocatorRepository;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;

class Edit extends Locator
{
    /**
     * @var LocatorFactory
     */
    private $locatorFactory;

    /**
     * @var LocatorRepository
     */
    private $repository;

    /**
     * @var Registry
     */
    private $registry;

    public function __construct(
        LocatorFactory $locatorFactory,
        LocatorRepository $repository,
        Registry $registry,
        Context $context
    ) {
        parent::__construct($context);
        $this->locatorFactory = $locatorFactory;
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
        $resultPage->setActiveMenu('Dco_Service::service_locator');
        $locator = $this->locatorFactory->create();

        if ($locatorId = (int) $this->getRequest()->getParam('locator_id')) {
            try {
                $locator = $this->repository->getById($locatorId);
                $resultPage->getConfig()->getTitle()->prepend($locator->getId() ? $locator->getName() : __('New Locator'));
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This locator no longer exists.'));

                return $this->_redirect('*/*/index');
            }
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Locator'));
        }

        $this->registry->register('booking_locator', $locator);

        return $resultPage;
    }
}
