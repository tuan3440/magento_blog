<?php

namespace Hust\Service\Controller\ServiceReview;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\PageFactory;
use Hust\Service\Model\ReviewFactory;
use Hust\Service\Model\ResourceModel\BookingSale;
use Hust\Service\Model\BookingSaleFactory;

class Save extends \Hust\Service\Controller\Index
{
    protected $review;
    protected $bookingsale;
    protected $bookingFactory;

    public function __construct(Context $context,
                                ReviewFactory $reviewFactory,
                                BookingSale $bookingsale,
                                BookingSaleFactory $bookingFactory,
                                PageFactory $resultPageFactory)
    {
        $this->review = $reviewFactory;
        $this->bookingsale = $bookingsale;
        $this->bookingFactory = $bookingFactory;
        parent::__construct($context, $resultPageFactory);
    }

    public function execute()
    {
        try{
            $review = $this->review->create();
            $service_id = $this->getRequest()->getParam("service_id");
            $idBookingSale = $this->getRequest()->getParam("id");
            $bookingSale = $this->bookingFactory->create()->load($idBookingSale);
            if (!$bookingSale->getIsReview()) {
                $point = $this->getRequest()->getParam("rating");
                $review->setPoint($point);
                $review->setServiceId($service_id);
                $review->save();
                $bookingSale->setIsReview(1);
                $bookingSale->save();
                $this->messageManager->addSuccessMessage(__('Thank you for your review'));
                $this->_redirect('bookings');
            } else {
                $this->messageManager->addWarningMessage(__("You can't review service"));
                $this->_redirect('bookings');
            }
        } catch (LocalizedException $e) {

        }
    }

}
