<?php

namespace Hust\Service\Controller\Adminhtml\Promotion;

use Hust\Service\Controller\Adminhtml\Promotion;
use Magento\Framework\App\ResponseInterface;

class Edit extends Promotion
{

    const CURRENT_PROMOTION = 'current_promotion';

    public function execute()
    {
        $promotionId = $this->getRequest()->getParam('promotion_id');
        $model = $this->getPromotionFactory()->create();
        if ($promotionId) {
            try {
                $model = $this->getPromotionRepository()->getById($promotionId);
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage($e->getMessage());
                $this->_redirect('*/*');

                return;
            }
        }

        $this->getServiceRegistry()->register(self::CURRENT_PROMOTION, $model);
        $this->initAction();
        $title = $model->getId() ? __('Edit Promotion `%1`', $model->getName()) : __("Add New Promotion");

        $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
        $this->_view->renderLayout();
    }

    private function initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Hust_Service::hust_promotion')->_addBreadcrumb(
            __('Promotion'),
            __('Promotion')
        );
        return $this;
    }
}
