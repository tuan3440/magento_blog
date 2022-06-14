<?php

namespace Hust\Service\Controller\ServiceReview;

use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Model\ServiceRegistry;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

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
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Review'));

        return $resultPage;
    }
}

