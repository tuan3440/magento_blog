<?php

namespace Hust\Service\Api\Data;

interface BookingInterface
{

    const BOOKING_ID = 'booking_id';
    const LOCATOR_ID = 'locator_id';
    const SERVICE_ID = 'service_id';
    const HOUR_BOOKING = 'hour_booking';
    const DATE_BOOKING = 'date';
    const NAME = 'name';
    const AGE = 'age';
    const GENDER = 'gender';
    const PHONE = 'phone';
    const EMAIL = 'email';
    const ADDRESS = 'address';
    const BOOKING_STATUS = 'booking_status';
    const CREATED_AT = 'created_at';

    public function getBookingId();
    public function setBookingId($id);
    public function getLocatorId();
    public function setLocatorId($locatorId);
    public function getServiceId();
    public function setServiceId($serviceId);
    public function getBookingStatus();
    public function setBookingStatus($status);
    public function getHourBooking();
    public function setHourBooking($hourBooking);
    public function getDateBooking();
    public function setDateBooking($dateBooking);
    public function getName();
    public function setName($name);
    public function getAge();
    public function setAge($age);
    public function getGender();
    public function setGender($gender);
    public function getPhone();
    public function setPhone($phone);
    public function getEmail();
    public function setEmail($email);
    public function getAddress();
    public function setAddress($address);
}
