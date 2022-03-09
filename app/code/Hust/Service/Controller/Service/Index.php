<?php

namespace Hust\Service\Controller\Service;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Hust\Service\Model\ServiceRegistry;
use Hust\Service\Model\Repository\ServiceRepository;

class Index extends \Hust\Service\Controller\Index
{
    private $registry;
    private $serviceRepository;
    public function __construct(Context $context,
                                PageFactory $resultPageFactory,
                                ServiceRegistry $registry,
                                ServiceRepository $serviceRepository
    )
    {
        $this->registry = $registry;
        $this->serviceRepository = $serviceRepository;
        parent::__construct($context, $resultPageFactory);
    }

    public function execute()
    {
        $serviceId = $this->getRequest()->getParam('id');
        $currentService = $this->serviceRepository->getById($serviceId);
        $this->registry->register('current_service', $currentService);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Spa Services'));

        return $resultPage;
    }
}
