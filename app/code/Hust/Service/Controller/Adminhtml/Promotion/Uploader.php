<?php

namespace Hust\Service\Controller\Adminhtml\Promotion;

use Hust\Service\Controller\Adminhtml\Promotion;
use Hust\Service\Model\PromotionFactory;
use Hust\Service\Model\Repository\PromotionRepository;
use Hust\Service\Model\ServiceRegistry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Uploader extends Promotion
{
    private $imageUploader;
    public function __construct(
        PageFactory $pageFactory,
        PromotionFactory $promotionFactory,
        PromotionRepository $promotionRepository,
        ServiceRegistry $serviceRegistry,
        \Magento\Catalog\Model\ImageUploader $imageUploader,
        Context $context)
    {
        $this->imageUploader = $imageUploader;
        parent::__construct($pageFactory, $promotionFactory, $promotionRepository, $serviceRegistry, $context);
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
