<?php
/**
 * Copyright © OpenTechiz, VietNam. All rights reserved.
 * See COPYING.txt for license details.
 * @package        OpenTechiz
 * @author         vuthuan <support@opentechiz.com>
 * @copyright      2021 Vu Thuan (03 2808 3090)
 */

namespace Dco\Service\Controller\Locator;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Dco\Service\Model\CalendarBooking;
use Dco\Service\Helper\Data;

class BookPost extends \Dco\Service\Controller\Index\Index
{
    const NUMBER_MAX = 5;
    protected $session;
    protected $calendar;
    protected $helper;

    public function __construct(Context $context,
                                PageFactory $resultPageFactory,
                                CalendarBooking $calendarBooking,
                                Data $helper,
                                Session $sessionFactory)
    {
        $this->session = $sessionFactory;
        $this->calendar = $calendarBooking;
        $this->helper = $helper;
        parent::__construct($context, $resultPageFactory);
    }

    public function execute()
    {
        if (!$this->session->isLoggedIn()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account/login');
            return $resultRedirect;
        }
        $data = $this->getRequest()->getParams();
        $pointReliable = $this->session->getCustomer()->getData("point");
        if ($pointReliable == '0') {
            $this->messageManager->addWarningMessage(__("Your account is locked from booking feature.Please come back later"));
            $this->_redirect('*/*/booknow', ['id' => $data['locator_id'], 'service' => $data['locator_id']]);
        } else {
            if (!isset($data['id'])) {
                $customerId = $this->session->getCustomer()->getEntityId();
                $calendar = $this->calendar;
                $time = strtotime($data['date']);
                $newformat = date('Y-m-d', $time);
                $calendar->setData('customer_id', $customerId);
                $calendar->setData('service_id', $data['service_id']);
                $calendar->setData('locator_id', $data['locator_id']);
                $calendar->setData('date', $newformat);
                $calendar->setData('hour', $data['hour']);
                $calendar->setData('require', $data['require']);
                $calendar->setData('booking_status', 0);
                try {
                    $calendar->save();
                } catch (\Exception $e) {
                    $this->messageManager->addExceptionMessage($e, __('Booking Calendar is not success'));
                }
                $this->messageManager->addSuccessMessage(__("You have booked success.Please check mail and follow instruction"));
                $this->_redirect('*/*/booknow', ['id' => $data['locator_id'], 'service' => $data['locator_id']]);
            }
        }

    }
}
