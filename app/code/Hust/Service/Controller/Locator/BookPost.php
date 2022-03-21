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

class BookPost extends Index
{
    protected $session;
    protected $bookingFactory;
    protected $bookingRepo;
    protected $timezone;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Session $session,
        BookingRepository $bookingRepository,
        BookingFactory $bookingFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    )
    {
        $this->timezone = $timezone;
        $this->session = $session;
        $this->bookingFactory = $bookingFactory;
        $this->bookingRepo = $bookingRepository;
        parent::__construct($context, $resultPageFactory);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            try {
                $model = $this->bookingFactory->create();
                $model->addData($data);
//                $stringDate = $model->getData('date');
//                $time_input = strtotime($stringDate);
//                $date_input = getDate($time_input);
//                $model->setDateBooking($date_input);
                $this->bookingRepo->save($model);
                $this->messageManager->addSuccessMessage(__('You book successful.'));
            } catch (LocalizedException $e) {

            }
        }
        $this->_redirect('*/*/booking', ['id'=>$data['locator_id'], 'service'=> $data['service_id']]);
    }
}
