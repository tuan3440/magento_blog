<?php

namespace Hust\Service\Block\Adminhtml;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton implements ButtonProviderInterface
{

    protected $urlBuilder;
    private $serviceRegistry;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Hust\Service\Model\ServiceRegistry $serviceRegistry
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->serviceRegistry = $serviceRegistry;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $id = $this->getItemId();
        if ($id) {
            $deleteUrl = $this->getUrlDelete($id);
//            $deleteUrl = $this->urlBuilder->getUrl('*/*/delete', ['service_id' => $id]);
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . $this->getConfirmText()
                    . '\', \'' . $deleteUrl . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    public function getUrlDelete($id)
    {
        return '';
    }

    /**
     * @return \Amasty\Blog\Model\BlogRegistry
     */
    public function getRegistry()
    {
        return $this->serviceRegistry;
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getConfirmText()
    {
        return __('Are you sure you want to delete this?');
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return 0;
    }
}
