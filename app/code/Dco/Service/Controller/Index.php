<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Controller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

abstract class Index extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context      $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */

    protected $registry;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

}
