<?php

namespace Hust\Service\Block\Adminhtml\Promotion;

use Hust\Service\Controller\Adminhtml\Promotion\Edit;

class DeleteButton extends \Hust\Service\Block\Adminhtml\DeleteButton
{
    public function getItemId()
    {
        return (int)$this->getRegistry()->registry(Edit::CURRENT_PROMOTION)->getData('promotion_id');
    }

    public function getUrlDelete($id)
    {
        return $this->urlBuilder->getUrl('*/*/delete', ['promotion_id' => $id]);
    }
}
