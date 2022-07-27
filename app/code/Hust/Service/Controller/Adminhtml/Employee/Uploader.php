<?php

namespace Hust\Service\Controller\Adminhtml\Employee;

use Hust\Service\Controller\Adminhtml\Employee;
use Hust\Service\Model\EmployeeFactory;
use Hust\Service\Model\Repository\EmployeeRepository;
use Hust\Service\Model\ResourceModel\Employee as ResourceEmployee;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;

class Uploader extends Employee
{
    private $imageUploader;



    public function __construct(Context $context,
                                Session $session,
                                PageFactory $resultPageFactory,
                                EmployeeFactory $employeeFactory,
                                EmployeeRepository $employeeRepository,
                                ServiceRegistry $serviceRegistry,
                                LayoutFactory $layoutFactory,
                                ResourceEmployee $resource,
                                \Magento\Catalog\Model\ImageUploader $imageUploader
    )
    {
        $this->imageUploader = $imageUploader;
        parent::__construct($context, $session, $resultPageFactory, $employeeFactory, $employeeRepository, $serviceRegistry, $layoutFactory, $resource);
    }

    public function execute()
    {
        try {
            $imageField = '';
            foreach ($this->getRequest()->getFiles() as $key => $file) {
                $imageField = $key;
                break;
            }
            $result = $this->imageUploader->saveFileToTmpDir($imageField);

            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
