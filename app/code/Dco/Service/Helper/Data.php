<?php
/**
 * Copyright © OpenTechiz, VietNam. All rights reserved.
 * See COPYING.txt for license details.
 * @package        OpenTechiz
 * @author         vuthuan <support@opentechiz.com>
 * @copyright      2021 Vu Thuan (03 2808 3090)
 */

namespace Dco\Service\Helper;


use Psr\Log\LoggerInterface;
use Magento\Framework\App\Area;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\MailException;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;

    public function __construct(
    Context $context,
    StateInterface $inlineTranslation,
    Escaper $escaper,
    TransportBuilder $transportBuilder
) {
    parent::__construct($context);
    $this->inlineTranslation = $inlineTranslation;
    $this->escaper = $escaper;
    $this->transportBuilder = $transportBuilder;
    $this->logger = $context->getLogger();
}

    public function sendEmail()
{
    try {
        $this->inlineTranslation->suspend();
        $sender = [
            'name' => $this->escaper->escapeHtml('Test'),
            'email' => $this->escaper->escapeHtml('tuannguyen190499@gmail.com'),
        ];
        $transport = $this->transportBuilder
            ->setTemplateIdentifier('notify_customer_cancel')
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars([
                'templateVar'  => 'My Topic',
            ])
            ->setFrom($sender)
            ->addTo('tuannguyen190499@gmail.com')
            ->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    } catch (\Exception $e) {
        $this->logger->debug($e->getMessage());
    }
}
}
