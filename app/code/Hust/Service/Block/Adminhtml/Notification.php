<?php

namespace Hust\Service\Block\Adminhtml;

class Notification extends \Magento\Backend\Block\Template
{

    /**
     * @var \Magento\Framework\Data\FormFactory
     */
    protected $configProvider;


    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Hust\Service\Model\Notification\BookingConfigProvider $configProvider,
        array $data = []
    ) {
        $this->configProvider = $configProvider;
        parent::__construct($context, $data);
    }

    public function getNotificationConfig()
    {
        $configData = $this->configProvider->getConfig();
        return $configData;
    }
}

