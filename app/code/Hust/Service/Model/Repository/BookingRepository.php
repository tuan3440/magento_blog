<?php

namespace Hust\Service\Model\Repository;

use Hust\Service\Api\BookingRepositoryInterface;
use Hust\Service\Api\Data\BookingInterface;
use Hust\Service\Model\ResourceModel\Booking;
use Hust\Service\Model\BookingFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BookingRepository implements BookingRepositoryInterface
{
    private $bookingFactory;
    private $bookingResource;
    private $bookings;

    public function __construct(
        BookingFactory $bookingFactory,
        Booking $bookingResource
    )
    {
        $this->bookingFactory = $bookingFactory;
        $this->bookingResource = $bookingResource;
    }
    public function save(BookingInterface $booking)
    {
        try {
            if ($booking->getBookingId()) {
                $booking = $this->getById($booking->getBookingId())->addData($booking->getData());
            } else {
                $booking->getBookingId(null);
            }
            $this->bookingResource->save($booking);
            unset($this->bookings[$booking->getBookingId()]);
        } catch (\Exception $e) {
            if ($booking->getBookingId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save booking with ID %1. Error: %2',
                        [$booking->getBookingId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new booking. Error: %1', $e->getMessage()));
        }
    }

    /**
     * @param $bookingId
     * @return \Hust\Service\Model\Booking|mixed
     * @throws NoSuchEntityException
     */
    public function getById($bookingId)
    {
        if (!isset($this->booking[$bookingId])) {
            $bookings = $this->bookingFactory->create();
            $this->bookingResource->load($bookings, $bookingId);
            if (!$bookings->getServiceId()) {
                throw new NoSuchEntityException(__('Booking with specified ID "%1" not found.', $bookingId));
            }
            $this->bookings[$bookingId] = $bookings;
        }
        return $this->bookings[$bookingId];
    }

    public function delete(BookingInterface $booking)
    {
        try {
            $this->bookingResource->delete($booking);
            unset($this->bookings[$booking->getBookingId()]);
        } catch (\Exception $e) {
            if ($booking->getServiceId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove booking with ID %1. Error: %2',
                        [$booking->getBookingId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(__('Unable to remove booking. Error: %1', $e->getMessage()));
        }
        return true;
    }

    public function deleteById($bookingId)
    {
        $bookingModel = $this->getById($bookingId);
        $this->delete($bookingModel);

        return true;
    }

}
