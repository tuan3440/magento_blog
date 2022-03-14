<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Hust\Service\Controller\Adminhtml\Booking;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResponseInterface;

class Save extends Booking
{

    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            try {
                $bookingRepo = $this->getBookingRepository()->getById($data['booking_id']);
                $bookingRepo->setBookingStatus($data['booking_status']);
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
}
