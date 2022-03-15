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

class Save extends Booking
{
    private $serviceRepo;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BookingFactory $bookingFactory,
        BookingRepository $bookingRepository,
        ServiceRegistry $serviceRegistry,
        LayoutFactory $layoutFactory,
        ServiceRepository $serviceRepo
    )
    {
        $this->serviceRepo = $serviceRepo;
        parent::__construct($context, $resultPageFactory, $bookingFactory, $bookingRepository, $serviceRegistry, $layoutFactory);
    }

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            try {
                $bookingRepo = $this->getBookingRepository()->getById($data['booking_id']);
                $bookingRepo->setBookingStatus($data['booking_status']);
                if ($data['booking_status'] == 3) {
                    $this->saveBookingSale($bookingRepo);
                }
                $this->getBookingRepository()->save($bookingRepo);
                $this->saveBookingEmployee($data);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));

            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the services.'));
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
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the services.'));
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
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the services.'));
        }
    }
}
