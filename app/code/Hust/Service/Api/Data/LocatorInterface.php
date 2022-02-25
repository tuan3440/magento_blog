<?php

namespace Hust\Service\Api\Data;

interface LocatorInterface
{
    const LOCATOR_ID = 'locator_id';
    const NAME = 'name';
    const CODE = 'code';
    const ADDRESS = 'address';
    const CITY = 'city';
    const COUNTRY = 'country';
    const PHONE = 'phone';
    const EMAIL = 'email';
    const IS_ACTIVE = 'is_active';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function getLocatorId();
    public function setLocatorId($locatorId);
    public function getName();
    public function setName($name);
    public function getCode();
    public function setCode($code);
    public function getAddress();
    public function setAddress($address);
    public function getCity();
    public function setCity($city);
    public function getCountry();
    public function setCountry($country);
    public function getPhone();
    public function setPhone($phone);
    public function getEmail();
    public function setEmail($email);
    public function getIsActive();
    public function setIsActive($isActive);

}
