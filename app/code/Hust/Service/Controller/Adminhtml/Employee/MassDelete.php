<?php

namespace Hust\Service\Controller\Adminhtml\Employee;

use Amasty\Blog\Controller\Adminhtml\AbstractMassAction;
use Magento\Framework\Data\Collection\AbstractDb;

class MassDelete extends \Hust\Service\Controller\Adminhtml\Employee\AbstractMassAction
{
    protected function itemAction($employee)
    {
        try {
            $this->getRepository()->deleteById($employee->getEmployeeId());
        } catch (\Exception $e) {
            $this->getMessageManager()->addErrorMessage($e->getMessage());
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    protected function getErrorMessage()
    {
        return __('We can\'t delete item right now. Please review the log and try again.');
    }

    /**
     * @param int $collectionSize
     *
     * @return \Magento\Framework\Phrase
     */
    protected function getSuccessMessage($collectionSize = 0)
    {
        return $collectionSize
            ? __('A total of %1 record(s) have been deleted.', $collectionSize)
            : __('No records have been deleted.');
    }
}
