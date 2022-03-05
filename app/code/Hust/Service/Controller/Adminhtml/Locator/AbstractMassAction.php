<?php

namespace Hust\Service\Controller\Adminhtml\Locator;

use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action;
use Psr\Log\LoggerInterface;

abstract class AbstractMassAction extends \Hust\Service\Controller\Adminhtml\AbstractMassAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Hust_Service::hust_locator';


    private $repository;
    private $collectionFactory;


    public function __construct(
        Action\Context $context,
        Filter $filter,
        LoggerInterface $logger,
        \Hust\Service\Api\LocatorRepositoryInterface $repository,
        \Hust\Service\Model\ResourceModel\Locator\CollectionFactory $collectionFactory
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

