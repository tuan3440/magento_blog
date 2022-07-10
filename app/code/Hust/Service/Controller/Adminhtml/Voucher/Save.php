<?php

namespace Hust\Service\Controller\Adminhtml\Voucher;

use Hust\Service\Controller\Adminhtml\Voucher;
use Hust\Service\Model\Repository\VoucherRepository;
use Hust\Service\Model\ServiceRegistry;
use Hust\Service\Model\VoucherFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Save extends Voucher
{
    public function __construct(Context $context, PageFactory $resultPageFactory, VoucherFactory $voucherFactory, VoucherRepository $voucherRepository, ServiceRegistry $serviceRegistry)
    {
        parent::__construct($context, $resultPageFactory, $voucherFactory, $voucherRepository, $serviceRegistry);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            $i = 1;
            while ($i <= $data['count']) {
                $voucher = $this->getVoucherFactory()->create();
                $code = (string) rand(100000,1000000).(string) rand(10,100);
                $voucher->setData('voucher_code', $code);
                $voucher->setData('discount', $data['discount']);
                $voucher->setData('date_end', $data['date_end']);
                try {
                    $voucher->save();
                    $i ++;
                } catch (\Exception $e) {

                }
            }
            $this->messageManager->addSuccessMessage(__('You saved vouchers successfully.'));
        }
        $this->_redirect('*/*/index');

    }
}
