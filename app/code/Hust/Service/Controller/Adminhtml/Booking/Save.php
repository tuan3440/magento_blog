<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;
use Hust\Service\Model\BookingFactory;
use Hust\Service\Model\Repository\BookingRepository;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Helper\Mail;
use Hust\Service\Model\Repository\LocatorRepository;
use Hust\Service\Model\Source\Hour;
use Hust\Service\Helper\Data;
use Hust\Service\Model\VoucherFactory;

class Save extends Booking
{
    private $serviceRepo;
    private $locatorRepo;
    private $mail;
    private $hour;
    private $helper;
    protected $voucher;
    public function __construct(
        Context $context,
        Session       $session,
        PageFactory $resultPageFactory,
        BookingFactory $bookingFactory,
        BookingRepository $bookingRepository,
        ServiceRegistry $serviceRegistry,
        LayoutFactory $layoutFactory,
        ServiceRepository $serviceRepo,
        LocatorRepository $locatorRepo,
        Mail $mail,
        Hour $hour,
        Data $helper,
        VoucherFactory $voucher
    )
    {
        $this->serviceRepo = $serviceRepo;
        $this->mail = $mail;
        $this->locatorRepo = $locatorRepo;
        $this->hour = $hour;
        $this->helper = $helper;
        $this->voucher = $voucher;
        parent::__construct($context, $session, $resultPageFactory, $bookingFactory, $bookingRepository, $serviceRegistry, $layoutFactory);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            try {
                $bookingRepo = $this->getBookingRepository()->getById($data['booking_id']);
                $bookingRepo->setData($data);
                $this->getBookingRepository()->save($bookingRepo);
                $bookingRepo = $this->getBookingRepository()->getById($data['booking_id']);
                if ($bookingRepo['booking_status'] == 3) {
                    $voucherCode = $this->createVoucher($data['booking_id']);
                    $this->sendMailSuccess($bookingRepo->getData('email'), $bookingRepo->getData('service_id'), $bookingRepo->getData('phone'), $voucherCode);
//                    $this->saveBookingSale($bookingRepo);
                }
                if ($bookingRepo['booking_status'] == 2) {
                    $this->sendMailCancel(['reason' => $bookingRepo->getData('reason')], $bookingRepo->getData('email'));
                }
                if ($bookingRepo['booking_status'] == 1) {
                    $this->sendMailAcept($bookingRepo);
                }

                if (isset($bookingRepo['employee_id']))
                    $this->saveBookingEmployee($data);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the booking.'));
            }
        }
        $this->_redirect('*/*/edit', ['booking_id' => $data['booking_id']]);

    }

    public function createVoucher($data)
    {
        $voucher = $this->voucher->create();
        $code = $data.(string) rand(100000,1000000);
        $today = date('Y-m-d');
        $month = strtotime(date("Y-m-d", strtotime($today)) . " +1 month");
        $dateEnd = strftime("%Y-%m-%d", $month);
        $voucher->setData('voucher_code', $code);
        $voucher->setData('date_end', $dateEnd);
        $voucher->setData('date_start', $today);
        try {
            $voucher->save();
        } catch (\Exception $e) {

        }
        return $code;
    }

    private function saveBookingEmployee($data)
    {
        try {
            $this->_resources = ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
            $connection = $this->_resources->getConnection();
            $table = $this->_resources->getTableName('hust_booking_employee');
            $where = [
                'booking_id = ?' => (int)$data['booking_id']
            ];
            $connection->delete($table, $where);
            $data = [
                'booking_id' => $data['booking_id'],
                'employee_id' => $data['employee_id']
            ];
            $connection->insert($table, $data);
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the booking.'));
        }
    }

    private function saveBookingSale($bookingRepo)
    {
        $bookingId = $bookingRepo->getData('booking_id');
        $serviceId = $bookingRepo->getData('service_id');
        $locatorId = $bookingRepo->getData('locator_id');
        $date = $bookingRepo->getData('date');
        $service = $this->serviceRepo->getById($serviceId);
        $charge = $bookingRepo->getData("charge");
        try {
            $this->_resources = ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
            $connection = $this->_resources->getConnection();
            $table = $this->_resources->getTableName('hust_booking_sale');
            $data = [
                'service_id' => $serviceId,
                'locator_id' => $locatorId,
                'date' => $date,
                'charge' => $charge,
                'phone' => $bookingRepo->getData('phone'),
                'email' => $bookingRepo->getData('email'),
                'name' => $bookingRepo->getData('name'),
                'employee_id' => $this->helper->getEmployeeOfBooking($bookingId)
            ];
            $connection->insert($table, $data);
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the booking.'));
        }
    }

    private function sendMailCancel($data, $email)
    {
        $this->mail->sendEmail("notify_cutomer_cancel", $data, $email);
    }

    private function sendMailAcept($data)
    {
        $dataformat = $this->convertData($data);
        $this->mail->sendEmail("notify_cutomer_accept", $dataformat, $data->getData('email'));
    }

    private function convertData($data)
    {
        $name = $data->getData('name');
        $serviceId = $data->getData('service_id');
        $locatorId = $data->getData('locator_id');
        $hours = $this->hour->toArray();
        $hourId = $data->getData('booking_hour');
        $date = $data->getData('date');
        $locator = $this->locatorRepo->getById($locatorId);
        $service = $this->serviceRepo->getById($serviceId);
        return [
            'name' => $name,
            'serviceName' => $service->getData('name'),
            'locatorName' => $locator->getData('name'),
            'address' => $locator->getData('address'),
            'date'=> $date,
            'hour'=> $hours[$hourId]
        ];
    }

    private function sendMailSuccess($email, $service_id, $phone, $voucherCode)
    {
        $url = $this->helper->getUrlReview($service_id, $phone);
        $this->mail->sendEmail("notify_cutomer_thankyou", [
            'urlReview' => $url,
            'code' => $voucherCode
        ], $email);
    }

    private function sendMailBoom($data)
    {

    }
}
