<?php

namespace Hust\Service\Api;

interface LocatorRepositoryInterface
{
    public function save(\Hust\Service\Api\Data\LocatorInterface $locator);
    public function getById($locatorId);
    public function delete(\Hust\Service\Api\Data\LocatorInterface $locator);
    public function deleteById($locatorId);
}
