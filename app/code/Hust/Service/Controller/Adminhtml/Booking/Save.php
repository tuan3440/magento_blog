<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;
use Hust\Service\Model\BookingFactory;
use Hust\Service\Model\Repository\BookingRepository;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Helper\Mail;

class Save extends Booking
{
    private $serviceRepo;
    private $mail;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BookingFactory $bookingFactory,
        BookingRepository $bookingRepository,
        ServiceRegistry $serviceRegistry,
        LayoutFactory $layoutFactory,
        ServiceRepository $serviceRepo,
        Mail $mail
    )
    {
        $this->serviceRepo = $serviceRepo;
        $this->mail = $mail;
        parent::__construct($context, $resultPageFactory, $bookingFactory, $bookingRepository, $serviceRegistry, $layoutFactory);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            try {
                $bookingRepo = $this->getBookingRepository()->getById($data['booking_id']);
                $bookingRepo->setBookingStatus($data['booking_status']);
                if (isset($data['reason']))
                    $bookingRepo->setReason($data['reason']);
                if ($data['booking_status'] == 3) {
                    $this->sendMailSuccess($data);
                    $this->saveBookingSale($bookingRepo);
                }
                if ($data['booking_status'] == 2) {
                    $this->sendMailCancel($data);
                }
                if ($data['booking_status'] == 1) {
                    $this->sendMailAcept($data);
                }
                if ($data['booking_status'] == 4) {
                    $this->sendMailBoom($data);
                }
                $this->getBookingRepository()->save($bookingRepo);
                if (isset($data['employee_id']))
                    $this->saveBookingEmployee($data);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the booking.'));
            }
        }
        $this->_redirect('*/*/edit', ['booking_id' => $data['booking_id']]);

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
        $serviceId = $bookingRepo->getData('service_id');
        $locatorId = $bookingRepo->getData('locator_id');
        $date = $bookingRepo->getData('date');
        $service = $this->serviceRepo->getById($serviceId);
        $charge = $service->getCharge();
        try {
            $this->_resources = ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
            $connection = $this->_resources->getConnection();
            $table = $this->_resources->getTableName('hust_booking_sale');
            $data = [
                'service_id' => $serviceId,
                'locator_id' => $locatorId,
                'date' => $date,
                'charge' => $charge
            ];
            $connection->insert($table, $data);
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the booking.'));
        }
    }

    private function sendMailCancel($data)
    {

    }

    private function sendMailAcept($data)
    {

    }

    private function sendMailSuccess($data)
    {
        $this->mail->sendEmail("notify_cutomer_thankyou", $data, $data['email']);
    }

    private function sendMailBoom($data)
    {

    }
}
