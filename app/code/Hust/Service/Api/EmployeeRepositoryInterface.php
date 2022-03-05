<?php

namespace Hust\Service\Api;

interface EmployeeRepositoryInterface
{
    public function save(\Hust\Service\Api\Data\EmployeeInterface $employee);
    public function getById($employeeId);
    public function delete(\Hust\Service\Api\Data\EmployeeInterface $employee);
    public function deleteById($employeeId);
}
