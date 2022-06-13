<?php

namespace Hust\Service\Controller\ServiceReview;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Hust\Service\Model\ReviewFactory;

class Save extends \Hust\Service\Controller\Index
{
    protected $review;
    public function __construct(Context $context,
                                ReviewFactory $reviewFactory,
                                PageFactory $resultPageFactory)
    {
        $this->review = $reviewFactory;
        parent::__construct($context, $resultPageFactory);
    }

    public function execute()
    {
        try{
            $review = $this->review->create();
            $service_id = 4;
            $point = $this->getRequest()->getParam("rating");
            $review->setPoint($point);
            $review->setServiceId($service_id);
            $review->save();
            $this->messageManager->addSuccessMessage(__('Thank you'));
            $this->_redirect('');
        } catch (LocalizedException $e) {

        }
    }
}
