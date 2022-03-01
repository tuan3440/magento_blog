<?php

namespace Hust\Service\Controller\Adminhtml\Service;

use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractMassAction
 */
abstract class AbstractMassAction extends \Hust\Service\Controller\Adminhtml\AbstractMassAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Hust_Service::hust_service';


    private $repository;
    private $collectionFactory;


    public function __construct(
        Action\Context $context,
        Filter $filter,
        LoggerInterface $logger,
        \Hust\Service\Api\ServiceRepositoryInterface $repository,
        \Hust\Service\Model\ResourceModel\Service\CollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $filter, $logger);
        $this->repository = $repository;
        $this->collectionFactory = $collectionFactory;
    }


    public function getRepository()
    {
        return $this->repository;
    }


    public function getCollection()
    {
        return $this->collectionFactory->create();
    }
}
