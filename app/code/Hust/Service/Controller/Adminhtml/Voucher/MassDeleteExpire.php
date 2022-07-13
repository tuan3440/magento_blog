<?php

namespace Hust\Service\Controller\Adminhtml\Voucher;

use Hust\Service\Controller\Adminhtml\Voucher;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class MassDeleteExpire extends Voucher
{

    public function execute()
    {
        $now = new \DateTime();
        $collection = $this->getVoucherFactory()->create()->getCollection()->addFieldToFilter('date_end', ['lteq' => $now->format('Y-m-d H:i:s')]);
        $collectionSize = $collection->getSize();

        if ($collection) {
            foreach ($collection as $c) {
                $c->delete();
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
