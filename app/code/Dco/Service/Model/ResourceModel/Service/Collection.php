<?php
/**
 * Copyright © OpenTechiz, VietNam. All rights reserved.
 * See COPYING.txt for license details.
 * @package        OpenTechiz
 * @author         vuthuan <support@opentechiz.com>
 * @copyright      2021 Vu Thuan (03 2808 3090)
 */

namespace Dco\Service\Model\ResourceModel\Service;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'service_id';

    protected function _construct()
    {
        $this->_init('Dco\Service\Model\Service', 'Dco\Service\Model\ResourceModel\Service');
    }
}
