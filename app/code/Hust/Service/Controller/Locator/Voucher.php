<?php

namespace Hust\Service\Controller\Locator;

use Hust\Service\Api\LocatorRepositoryInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\LayoutFactory;
use Hust\Service\Model\ResourceModel\Voucher as ResourceVoucher;
class Voucher extends Action
{
    /**
     * @var LocatorRepositoryInterface
     */
    protected $locatorRepository;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;
    protected $voucher;

    /**
     * Find constructor.
     * @param Context $context
     * @param LocatorRepositoryInterface $locatorRepository
     * @param ProductFactory $productFactory
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        Context $context,
        LocatorRepositoryInterface $locatorRepository,
        ProductFactory $productFactory,
        LayoutFactory $layoutFactory,
        ResourceVoucher $voucher
    ) {
        $this->locatorRepository = $locatorRepository;
        $this->productFactory = $productFactory;
        $this->layoutFactory = $layoutFactory;
        $this->voucher = $voucher;
        parent::__construct($context);
    }
    public function execute()
    {
        $response = [];
//        $layout = $this->layoutFactory->create();
        $code = $this->getRequest()->getParam('code', 0);

        $voucher = $this->voucher->checkVoucherCode($code);
        if ($voucher) {
            $response['code'] = $voucher;
            $response['has'] = true;
        } else {
            $response['has'] = false;
        }
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($response);
        return $resultJson;
    }
}
