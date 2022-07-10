<?php

namespace Hust\Service\Model\Repository;

use Hust\Service\Api\VoucherRepositoryInterface;
use Hust\Service\Api\Data\VoucherInterface;
use Hust\Service\Model\ResourceModel\Voucher;
use Hust\Service\Model\VoucherFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class VoucherRepository implements  VoucherRepositoryInterface
{
    private $voucherFactory;
    private $voucherResource;
    private $vouchers;

    public function __construct(
        VoucherFactory $voucherFactory,
        Voucher $voucherResource
    )
    {
        $this->voucherFactory = $voucherFactory;
        $this->voucherResource = $voucherResource;
    }

    public function save(VoucherInterface $voucher)
    {
        try {
            if ($voucher->getVoucherId()) {
                $voucher = $this->getById($voucher->getVoucherId())->addData($voucher->getData());
            } else {
                $voucher->setVoucherId(null);
            }
            $this->voucherResource->save($voucher);
            unset($this->vouchers[$voucher->getVoucherId()]);
        } catch (\Exception $e) {
            if ($voucher->getVoucherId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save voucher with ID %1. Error: %2',
                        [$voucher->getVoucherId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new voucher. Error: %1', $e->getMessage()));
        }
    }

    public function getById($voucherId)
    {
        if (!isset($this->vouchers[$voucherId])) {
            $voucher = $this->voucherFactory->create();
            $this->voucherResource->load($voucher, $voucherId);
            if (!$voucher->getVoucherId()) {
                throw new NoSuchEntityException(__('Voucher with specified ID "%1" not found.', $voucherId));
            }
            $this->vouchers[$voucherId] = $voucher;
        }
        return $this->vouchers[$voucherId];
    }

    public function delete(VoucherInterface $voucher)
    {
        try {
            $this->voucherResource->delete($voucher);
            unset($this->vouchers[$voucher->getVoucherId()]);
        } catch (\Exception $e) {
            if ($voucher->getVoucherId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove voucher with ID %1. Error: %2',
                        [$voucher->getVoucherId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotDeleteException(__('Unable to remove voucher. Error: %1', $e->getMessage()));
        }
        return true;
    }

    public function deleteById($voucherId)
    {
        $voucherModel = $this->getById($voucherId);
        $this->delete($voucherModel);

        return true;
    }
}
