<?php

namespace Hust\Service\Controller\Locator;

use Hust\Service\Controller\Index;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;
use Hust\Service\Model\Repository\BookingRepository;
use Hust\Service\Model\BookingFactory;
use Hust\Service\Model\VoucherFactory;
use Hust\Service\Helper\Mail;

class BookPost extends Index
{
    protected $session;
    protected $bookingFactory;
    protected $bookingRepo;
    protected $timezone;
    protected $mail;
    protected $voucher;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Session $session,
        BookingRepository $bookingRepository,
        BookingFactory $bookingFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        Mail $mail,
        VoucherFactory $voucher
    )
    {
        $this->timezone = $timezone;
        $this->session = $session;
        $this->bookingFactory = $bookingFactory;
        $this->bookingRepo = $bookingRepository;
        $this->mail = $mail;
        $this->voucher = $voucher;
        parent::__construct($context, $resultPageFactory);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            try {
                $model = $this->bookingFactory->create();
                $data['admin_notification'] = 1;
                $model->addData($data);
                $this->bookingRepo->save($model);
                $this->removeVoucher($data['voucher_id']);
                $this->messageManager->addSuccessMessage(__('You book successful. We will contact with you now!'));
            } catch (LocalizedException $e) {

            }
        }
        $this->_redirect('*/*/booking', ['id'=>$data['locator_id'], 'service'=> $data['service_id']]);
    }

    public function removeVoucher($voucherId)
    {
        try {
            $this->voucher->create()->load($voucherId)->delete();
        } catch (LocalizedException $e) {

        }

    }

}
