<?php

namespace Hust\Service\Block\Adminhtml\Locator;

use Hust\Service\Controller\Adminhtml\Locator\Edit;

class DeleteButton extends \Hust\Service\Block\Adminhtml\DeleteButton
{
    public function getItemId()
    {
        return (int)$this->getRegistry()->registry(Edit::CURRENT_LOCATOR)->getLocatorId();
    }

    public function getUrlDelete($id)
    {
        return $this->urlBuilder->getUrl('*/*/delete', ['locator_id' => $id]);
    }
}
