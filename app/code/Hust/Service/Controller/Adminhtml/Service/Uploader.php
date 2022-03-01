<?php

namespace Hust\Service\Controller\Adminhtml\Service;

use Hust\Service\Controller\Adminhtml\Service;
use Hust\Service\Model\Repository\ServiceRepository;
use Hust\Service\Model\ServiceFactory;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Uploader extends Service
{
    private $imageUploader;
    public function __construct(Context $context, PageFactory $resultPageFactory, ServiceFactory $serviceFactory, ServiceRepository $serviceRepository, ServiceRegistry $serviceRegistry,
                                \Magento\Catalog\Model\ImageUploader $imageUploader)
    {
        $this->imageUploader = $imageUploader;
        parent::__construct($context, $resultPageFactory, $serviceFactory, $serviceRepository, $serviceRegistry);
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
