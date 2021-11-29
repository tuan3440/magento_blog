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

class Data extends AbstractHelper
{
    const EMAIL_TEMPLATE = 'email_section/sendmail/email_template';

    const EMAIL_SERVICE_ENABLE = 'email_section/sendmail/enabled';

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Data constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        LoggerInterface $logger
    )
    {
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Send Mail
     *
     * @return $this
     *
     * @throws LocalizedException
     * @throws MailException
     */
    public function sendMail()
    {
        $email = 'tuannguyen190499@gmail.com'; //set receiver mail

        $this->inlineTranslation->suspend();
        $storeId = $this->getStoreId();

//        /* email template */
//        $template = $this->scopeConfig->getValue(
//            self::EMAIL_TEMPLATE,
//            ScopeInterface::SCOPE_STORE,
//            $storeId
//        );
//
//        $vars = [
//            'message_1' => 'CUSTOM MESSAGE STR 1',
//            'message_2' => 'custom message str 2',
//            'store' => $this->getStore()
//        ];

        // set from email
//        $sender = $this->scopeConfig->getValue(
//            'email_section/sendmail/sender',
//            ScopeInterface::SCOPE_STORE,
//            $this->getStoreId()
//        );
        $a = __("xxx");
        $store = $this->storeManager->getStore();
        $transport = $this->transportBuilder->setTemplateIdentifier(
            'notify_cutomer_cancel'
        )->setTemplateOptions(
            ['area' => 'frontend', 'store' => $store->getId()]
        )->addTo(
            'tuannguyen1904@gmail.com', "Tuandz"
        )->setTemplateVars([
            'a' => $a
        ])->setFrom(
            'general'
        )->getTransport();

        try {
            $transport->sendMessage();
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }
        $this->inlineTranslation->resume();

        return $this;
    }

    /*
     * get Current store id
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    /*
     * get Current store Info
     */
    public function getStore()
    {
        return $this->storeManager->getStore();
    }
}
