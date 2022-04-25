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
use Hust\Service\Helper\Mail;

class BookPost extends Index
{
    protected $session;
    protected $bookingFactory;
    protected $bookingRepo;
    protected $timezone;
    protected $mail;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Session $session,
        BookingRepository $bookingRepository,
        BookingFactory $bookingFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        Mail $mail
    )
    {
        $this->timezone = $timezone;
        $this->session = $session;
        $this->bookingFactory = $bookingFactory;
        $this->bookingRepo = $bookingRepository;
        $this->mail = $mail;
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
                $this->sendMailWaiting($model);
                $this->messageManager->addSuccessMessage(__('You book successful.'));
            } catch (LocalizedException $e) {

            }
        }
        $this->_redirect('*/*/booking', ['id'=>$data['locator_id'], 'service'=> $data['service_id']]);
    }

    private function sendMailWaiting($model)
    {
        $variables = [
            'name' => $model->getData('name'),
            'email' => $model->getData('email')
        ];
        try {
            $this->mail->sendEmail('notify_cutomer_waiting', $variables, $variables['email']);
        } catch (\Exception $e) {

        }
    }
}
