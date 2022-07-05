<?php

namespace Hust\Service\Controller\Adminhtml\Locator;

use Hust\Service\Controller\Adminhtml\Locator;
use Magento\Framework\App\ResponseInterface;

class Edit extends Locator
{
    const CURRENT_LOCATOR = 'current_locator';

    public function execute()
    {
        $locatorId = $this->getRequest()->getParam('locator_id');

        $model = $this->getLocatorFactory()->create();
        if ($locatorId) {
            try {
                $model = $this->getLocatorRepository()->getById($locatorId);
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage($e->getMessage());
                $this->_redirect('*/*');

                return;
            }
        }
        if (!$this->checkLocator($locatorId)) {
            $this->getMessageManager()->addErrorMessage(__("Error Permission"));
            $this->_redirect('*/*');
            return;
        }

        $this->getServiceRegistry()->register(self::CURRENT_LOCATOR, $model);
        $this->initAction();
        $title = $model->getId() ? __('Edit Locator `%1`', $model->getName()) : __("Add New Locator");

        $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
        $this->_view->renderLayout();
    }

    private function initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Hust_Service::hust_locator')->_addBreadcrumb(
            __('Locator'),
            __('Locator')
        );
        return $this;
    }
}
