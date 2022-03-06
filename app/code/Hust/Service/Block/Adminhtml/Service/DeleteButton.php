<?php

namespace Hust\Service\Block\Adminhtml\Service;

use Hust\Service\Controller\Adminhtml\Service\Edit;
class DeleteButton extends \Hust\Service\Block\Adminhtml\DeleteButton
{
    public function getItemId()
    {
        return (int)$this->getRegistry()->registry(Edit::CURRENT_SERVICE)->getServiceId();
    }

    public function getUrlDelete($id)
    {
         return $this->urlBuilder->getUrl('*/*/delete', ['service_id' => $id]);
    }
}
