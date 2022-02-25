<?php

namespace Hust\Service\Controller\Adminhtml\Service;

use Hust\Service\Controller\Adminhtml\Service;
use Magento\Framework\App\ResponseInterface;

class Edit extends Service
{
    const CURRENT_SERVICE = 'current_service';

    public function execute()
    {
        $serviceId = $this->getRequest()->getParam('service_id');
        $model = $this->getServiceFactory()->create();
        if ($serviceId) {
            try {
                $model = $this->getServiceRepository()->getById($serviceId);
            } catch (\Exception $e) {
                $this->getMessageManager()->addErrorMessage($e->getMessage());
                $this->_redirect('*/*');

                return;
            }
        }

        $this->getServiceRegistry()->register(self::CURRENT_SERVICE, $model);
        $this->initAction();
        $title = $model->getId() ? __('Edit Service `%1`', $model->getName()) : __("Add New Service");

        $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
        $this->_view->renderLayout();
    }

    private function initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Hust_Service::hust_service')->_addBreadcrumb(
            __('Service'),
            __('Service')
        );
        return $this;
    }
}
