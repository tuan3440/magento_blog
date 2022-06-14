<?php

namespace Hust\Service\Controller\ServiceReview;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Hust\Service\Model\ReviewFactory;
use Hust\Service\Model\ResourceModel\BookingSale;

class Save extends \Hust\Service\Controller\Index
{
    protected $review;
    protected $bookingsale;

    public function __construct(Context $context,
                                ReviewFactory $reviewFactory,
                                BookingSale $bookingsale,
                                PageFactory $resultPageFactory)
    {
        $this->review = $reviewFactory;
        $this->bookingsale = $bookingsale;
        parent::__construct($context, $resultPageFactory);
    }

    public function execute()
    {
        try{
            $review = $this->review->create();
            $service_id = $this->getRequest()->getParam("service_id");
            $phone = $this->getRequest()->getParam("phone");
            if ($this->checkPhone($phone, $service_id)) {
                $point = $this->getRequest()->getParam("rating");
                $review->setPoint($point);
                $review->setServiceId($service_id);
                $review->save();
                $this->messageManager->addSuccessMessage(__('Thank you for your review'));
                $this->_redirect('bookings');
            } else {
                $this->messageManager->addWarningMessage(__("You can't review service"));
                $this->_redirect('bookings');
            }
        } catch (LocalizedException $e) {

        }
    }

    public function checkPhone($phone, $service_id)
    {
        $phones = $this->bookingsale->getListPhone($service_id);
        foreach ($phones as $p) {
            if ($p['phone'] == $phone) return true;
        }
        return false;
    }
}
