<?php
/**
 * @author ArrowHiTech Team
 * @copyright Copyright (c) 2021 ArrowHiTech (https://www.arrowhitech.com)
 */
namespace Dco\Service\Controller\Adminhtml\Service;

use Dco\Service\Model\ServiceRepository;
use Dco\Service\Controller\Adminhtml\Service;
use Magento\Backend\App\Action\Context;
use Psr\Log\LoggerInterface;

class Delete extends Service
{
    /**
     * @var ServiceRepository
     */
    private $repository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ServiceRepository $repository,
        LoggerInterface $logger,
        Context $context
    ) {
        parent::__construct($context);
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function execute()
    {
        if ($iconId = $this->getRequest()->getParam('service_id')) {
            try {
                $this->repository->deleteById($iconId);
                $this->messageManager->addSuccessMessage(__('You deleted the service.'));
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('We can\'t delete item right now. Please review the log and try again.')
                );
                $this->logger->critical($e);
            }
        }
        $this->_redirect('*/*/');
    }
}
