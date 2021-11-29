<?php
/**
 * Copyright © OpenTechiz, VietNam. All rights reserved.
 * See COPYING.txt for license details.
 * @package        OpenTechiz
 * @author         vuthuan <support@opentechiz.com>
 * @copyright      2021 Vu Thuan (03 2808 3090)
 */

namespace Dco\Service\Controller\Adminhtml\Calendar;


use Dco\Service\Controller\Adminhtml\Calendar;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends Calendar
{

    /**
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Dco_Service::booking_calendar');
        $resultPage->addBreadcrumb(__('Booking'), __('Booking'));
        $resultPage->addBreadcrumb(__('Booking Calendar'), __('Booking Calendar'));
        $resultPage->getConfig()->getTitle()->prepend(__('Booking Calendar'));

        return $resultPage;
    }
}
