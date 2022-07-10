<?php

namespace Hust\Service\Controller\Adminhtml\Voucher;

use Hust\Service\Controller\Adminhtml\Voucher;
use Hust\Service\Model\Repository\VoucherRepository;
use Hust\Service\Model\ServiceRegistry;
use Hust\Service\Model\VoucherFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Hust\Service\Model\ResourceModel\Voucher\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class MassDelete extends Voucher
{
    protected $collection;
    protected $filter;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        VoucherFactory $voucherFactory,
        VoucherRepository $voucherRepository,
        ServiceRegistry $serviceRegistry,
        CollectionFactory $collectionFactory,
        Filter $filter
    )
    {
        $this->collection = $collectionFactory;
        $this->filter = $filter;
        parent::__construct($context, $resultPageFactory, $voucherFactory, $voucherRepository, $serviceRegistry);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collection->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
