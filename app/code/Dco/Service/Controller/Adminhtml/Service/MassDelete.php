<?php
/**
 * @author ArrowHiTech Team
 * @copyright Copyright (c) 2021 ArrowHiTech (https://www.arrowhitech.com)
 */
namespace Dco\Service\Controller\Adminhtml\Service;

use Dco\Service\Api\ServiceRepositoryInterface;
use Dco\Service\Model\ResourceModel\Service\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use Magento\Ui\Component\MassAction\Filter;
use Psr\Log\LoggerInterface;

class MassDelete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dco_Service::service';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $serviceCollectionFactory;

    /**
     * @var ServiceRepositoryInterface
     */
    protected $repository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        ServiceRepositoryInterface $repository,
        CollectionFactory $serviceCollectionFactory,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->repository = $repository;
        $this->serviceCollectionFactory = $serviceCollectionFactory;
        $this->logger = $logger;
    }

    /**
     * Mass action execution
     * @throws LocalizedException
     */
    public function execute()
    {
        $this->filter->applySelectionOnTargetProvider();
        $collection = $this->filter->getCollection($this->serviceCollectionFactory->create());
        $collectionSize = $collection->getSize();
        if ($collectionSize) {
            try {
                foreach ($collection->getItems() as $service) {
                    $this->repository->deleteById($service);
                }
                $this->messageManager->addSuccessMessage($this->getSuccessMessage($collectionSize));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($this->getErrorMessage());
                $this->logger->critical($e);
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * @return Phrase
     */
    protected function getErrorMessage()
    {
        return __('We can\'t delete item right now. Please review the log and try again.');
    }

    /**
     * @param int $collectionSize
     *
     * @return Phrase
     */
    protected function getSuccessMessage($collectionSize = 0)
    {
        if ($collectionSize) {
            return __('A total of %1 record(s) have been deleted.', $collectionSize);
        }

        return __('No records have been deleted.');
    }
}
