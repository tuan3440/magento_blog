<?php

namespace Hust\Service\Block\Adminhtml\Employee;

use Hust\Service\Controller\Adminhtml\Employee\Edit;

class DeleteButton extends \Hust\Service\Block\Adminhtml\DeleteButton
{
    public function getItemId()
    {
        return (int)$this->getRegistry()->registry(Edit::CURRENT_EMPLOYEE)->getEmployeeId();
    }

    public function getUrlDelete($id)
    {
        return $this->urlBuilder->getUrl('*/*/delete', ['employee_id' => $id]);
    }
}
