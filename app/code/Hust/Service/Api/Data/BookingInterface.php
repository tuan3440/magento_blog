<?php

namespace Hust\Service\Api\Data;

interface BookingInterface
{

    const BOOKING_ID = 'booking_id';
    const CUSTOMER_ID = 'customer_id';
    const LOCATOR_ID = 'locator_id';
    const SERVICE_ID = 'service_id';
    const HOUR_BOOKING = 'hour_booking';
    const DATE_BOOKING = 'date_booking';
    const BOOKING_STATUS = 'booking_status';
    const CREATED_AT = 'created_at';

    public function getBookingId();
    public function setBookingId($id);
    public function getLocatorId();
    public function setLocatorId($locatorId);
    public function getServiceId();
    public function setServiceId($serviceId);
    public function getCustomerId();
    public function setCustomerId($customerId);
    public function getBookingStatus();
    public function setBookingStatus($status);
    public function getHourBooking();
    public function setHourBooking($hourBooking);
    public function getDateBooking();
    public function setDateBooking($dateBooking);

}
