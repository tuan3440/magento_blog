<?php
/**
 * Copyright © OpenTechiz, VietNam. All rights reserved.
 * See COPYING.txt for license details.
 * @package        OpenTechiz
 * @author         vuthuan <support@opentechiz.com>
 * @copyright      2021 Vu Thuan (03 2808 3090)
 */

namespace Dco\Service\Model;

use Magento\Framework\Model\AbstractModel;
class CalendarBooking extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Dco\Service\Model\ResourceModel\CalendarBooking');
    }
}
