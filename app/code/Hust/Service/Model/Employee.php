<?php

namespace Hust\Service\Model;

use Hust\Service\Api\Data\EmployeeInterface;
use Hust\Service\Api\Data\LocatorInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Employee extends AbstractModel implements IdentityInterface, EmployeeInterface
{
    const CACHE_TAG = 'hust_employee';

    protected function _construct()
    {
        $this->_init('Hust\Service\Model\ResourceModel\Employee');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getEmployeeId()
    {
        return $this->getData(EmployeeInterface::EMPLOYEE_ID);
    }

    public function setEmployeeId($id)
    {
        $this->setData(EmployeeInterface::EMPLOYEE_ID, $id);
        return $this;
    }

    public function getImage()
    {
        return $this->getData(EmployeeInterface::IMAGE);
    }

    public function setImage($image)
    {
        $this->setData(EmployeeInterface::IMAGE, $image);
        return $this;
    }

    public function getFirstName()
    {
        return $this->getData(EmployeeInterface::FIRST_NAME);
    }

    public function setFirstName($firstName)
    {
        $this->setData(EmployeeInterface::FIRST_NAME, $firstName);
        return $this;
    }

    public function getLastName()
    {
        return $this->getData(EmployeeInterface::LAST_NAME);
    }

    public function setLastName($lastName)
    {
        $this->setData(EmployeeInterface::LAST_NAME, $lastName);
        return $this;
    }

    public function getGender()
    {
        return $this->getData(EmployeeInterface::GENDER);
    }

    public function setGender($gender)
    {
        $this->setData(EmployeeInterface::GENDER, $gender);
        return $this;
    }

    public function getAddress()
    {
        return $this->getData(EmployeeInterface::ADDRESS);
    }

    public function setAddress($sddress)
    {
        $this->setData(EmployeeInterface::ADDRESS, $sddress);
        return $this;
    }

    public function getDescription()
    {
        return $this->getData(EmployeeInterface::DESCRIPTION);
    }

    public function setDescription($description)
    {
        $this->setData(EmployeeInterface::DESCRIPTION, $description);
        return $this;
    }

    public function getPhone()
    {
        return $this->getData(EmployeeInterface::PHONE);
    }

    public function setPhone($phone)
    {
        $this->setData(EmployeeInterface::PHONE, $phone);
        return $this;
    }

    public function getDateOfBirth()
    {
        return $this->getData(EmployeeInterface::DATE_OF_BIRTH);
    }

    public function setDateOfBirth($date)
    {
        $this->setData(EmployeeInterface::DATE_OF_BIRTH, $date);
        return $this;
    }
}
