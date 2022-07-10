<?php

namespace Hust\Service\Api;

interface VoucherRepositoryInterface
{
    public function save(\Hust\Service\Api\Data\VoucherInterface $voucher);
    public function getById($voucherId);
    public function delete(\Hust\Service\Api\Data\VoucherInterface $voucher);
    public function deleteById($voucherId);
}
