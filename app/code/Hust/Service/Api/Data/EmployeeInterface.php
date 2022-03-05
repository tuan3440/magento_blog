<?php

namespace Hust\Service\Api\Data;

interface EmployeeInterface
{
    const EMPLOYEE_ID = 'employee_id';
    const IMAGE = 'image';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const GENDER = 'gender';
    const ADDRESS = 'address';
    const DESCRIPTION = 'description';
    const PHONE = 'phone';
    const DATE_OF_BIRTH = 'date_of_birth';

    public function getEmployeeId();
    public function setEmployeeId($id);
    public function getImage();
    public function setImage($image);
    public function getFirstName();
    public function setFirstName($firstName);
    public function getLastName();
    public function setLastName($lastName);
    public function getGender();
    public function setGender($gender);
    public function getAddress();
    public function setAddress($sddress);
    public function getDescription();
    public function setDescription($description);
    public function getPhone();
    public function setPhone($phone);
    public function getDateOfBirth();
    public function setDateOfBirth($date);
}
