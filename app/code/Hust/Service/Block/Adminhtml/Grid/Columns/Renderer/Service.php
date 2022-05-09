<?php

namespace Hust\Service\Block\Adminhtml\Grid\Columns\Renderer;

use Magento\Backend\Block\Context;
use Magento\FrameWork\DataObject;
use Hust\Service\Model\Repository\ServiceRepository;

class Service extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $service;
    public function __construct(Context $context,
                                ServiceRepository $serviceRepository,
                                array $data = [])
    {
        $this->service = $serviceRepository;
        parent::__construct($context, $data);
    }

    public function render(DataObject $row)
    {
        $serviceId = $row->getServiceId();
        $service = $this->service->getById($serviceId);
        return $service->getData('name');
    }
}
