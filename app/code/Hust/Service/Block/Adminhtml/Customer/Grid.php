<?php

namespace Hust\Service\Block\Adminhtml\Customer;

use Magento\Framework\App\ObjectManager;
use Hust\Service\Model\ResourceModel\BookingSale\CollectionFactory;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $collection;
    /**
     * Grid constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collection = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _prepareCollection()
    {
        $collection = $this->collection->create();
        $collection->getSelect()->group(['phone', 'email'])->columns([
            'count' => 'count(*)'
        ]);
//        echo $collection->getSelect()->__toString();
//        die;
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return $this
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
//        $this->addColumn(
//            'id',
//            ['header' => __('ID'),
//                'index' => 'id',
//            ]
//        );
//        $this->addColumn(
//            'name',
//            [
//                'header' => __('Name'),
//                'index' => 'name',
//            ]
//        );
        $this->addColumn(
            'phone',
            [
                'header' => __('Phone'),
                'index' => 'phone',
            ]
        );
        $this->addColumn(
            'email',
            [
                'header' => __('Email'),
                'index' => 'email',
            ]
        );
        $this->addColumn(
            'count',
            [
                'header' => __('Numbers use service'),
                'index' => 'count',
            ]
        );

        $this->addExportType('*/booking/exportReportCustomerCsv', __('CSV'));
        $this->addExportType('*/booking/exportReportCustomerExcel', __('Excel XML'));
        return $this;
    }
}
