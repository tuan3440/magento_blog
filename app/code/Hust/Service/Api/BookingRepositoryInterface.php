<?php

namespace Hust\Service\Api;

interface BookingRepositoryInterface
{
    public function save(\Hust\Service\Api\Data\BookingInterface $booking);
    public function getById($bookingId);
    public function delete(\Hust\Service\Api\Data\BookingInterface $booking);
    public function deleteById($bookingId);
}
