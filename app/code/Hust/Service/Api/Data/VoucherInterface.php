<?php

namespace Hust\Service\Api\Data;

interface VoucherInterface
{
    const VOUCHER_ID = 'voucher_id';
    const VOUCHER_CODE = 'voucher_code';
    const DISCOUNT = 'discount';
    const DATE_END = 'date_end';

    public function getVoucherId();
    public function setVoucherId($voucherId);
    public function getVoucherCode();
    public function setVoucherCode($voucherCode);
    public function getDiscount();
    public function setDiscount($discount);
    public function getDateEnd();
    public function setDateEnd($dateend);
}
