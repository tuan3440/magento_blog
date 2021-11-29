<?php
/**
 * @author ArrowHiTech Team
 * @copyright Copyright (c) 2021 ArrowHiTech (https://www.arrowhitech.com)
 */
namespace Dco\Service\Model;

use Dco\Service\Api\Data\ServiceInterface;
use Magento\Framework\Model\AbstractModel;

class Service extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Dco\Service\Model\ResourceModel\Service');
    }
}
