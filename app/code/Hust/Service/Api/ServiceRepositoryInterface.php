<?php

namespace Hust\Service\Api;

interface ServiceRepositoryInterface
{
    public function save(\Hust\Service\Api\Data\ServiceInterface $service);
    public function getById($serviceId);
    public function delete(\Hust\Service\Api\Data\ServiceInterface $service);
    public function deleteById($serviceId);
}
