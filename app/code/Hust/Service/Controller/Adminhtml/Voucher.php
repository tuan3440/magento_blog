<?php

namespace Hust\Service\Controller\Adminhtml;

use Hust\Service\Model\Repository\VoucherRepository;
use Hust\Service\Model\VoucherFactory;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

abstract class Voucher extends Action
{
    const ADMIN_RESOURCE = 'Hust_Service::hust_voucher';

    protected $resultPageFactory;
    private $voucherFactory;
    private $voucherRepository;
    private $serviceRegistry;


    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        VoucherFactory $voucherFactory,
        VoucherRepository $voucherRepository,
        ServiceRegistry $serviceRegistry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->voucherFactory = $voucherFactory;
        $this->voucherRepository = $voucherRepository;
        $this->serviceRegistry = $serviceRegistry;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }

    protected function getVoucherFactory()
    {
        return $this->voucherFactory;
    }

    protected function getVoucherRepository()
    {
        return $this->voucherRepository;
    }

    protected function getServiceRegistry()
    {
        return $this->serviceRegistry;
    }
}

