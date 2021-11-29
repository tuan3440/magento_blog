<?php
/**
 * Copyright © OpenTechiz, VietNam. All rights reserved.
 * See COPYING.txt for license details.
 * @package        OpenTechiz
 * @author         vuthuan <support@opentechiz.com>
 * @copyright      2021 Vu Thuan (03 2808 3090)
 */

namespace Dco\Service\Controller\Customer;


class Calendar extends \Magento\Framework\App\Action\Action {
    public function execute() {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
