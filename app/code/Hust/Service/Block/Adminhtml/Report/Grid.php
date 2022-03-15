<?php

namespace Hust\Service\Block\Adminhtml\Report;

use Magento\Backend\Block\Widget\Grid\Extended;
use Zend_Date;
use Hust\Service\Model\ResourceModel\BookingSale\CollectionFactory;
use Magento\Framework\Stdlib\DateTime;

class Grid extends Extended
{
    protected $_collectionFactory;
    protected $_columnGroupBy = 'period';
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        CollectionFactory $collection,
        array $data = [])
    {
        $this->_collectionFactory = $collection;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setFilterVisibility(false);
        $this->setPagerVisibility(true);
        $this->setCountTotals(true);
        if (isset($this->_columnGroupBy)) {
            $this->isColumnGrouped($this->_columnGroupBy, true);
        }
        $this->setEmptyCellLabel(__('We can\'t find records for this period.'));
    }

    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();

        $params = $this->getFilterData();
//        if ($params && $params->getData()) {
//            $from = $params->getFrom();
//            $to = $params->getTo();
//            $from = $this->_prepareDateFrom($from);
//            $to = $this->_prepareDateTo($to);
//
//            $collection->addFieldToFilter('date', ['from' => $from . ' 00:00:00', 'to' => $to . ' 23:59:59']);
//        } else {
//            $collection->getSelect()->where('main_table.id =?', 0);
//        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareDateFrom($date)
    {
        $start = new Zend_Date($date, DateTime::DATE_INTERNAL_FORMAT);
        $dateStart = new Zend_Date(date("Y-m-d", $start->getTimestamp()), DateTime::DATE_INTERNAL_FORMAT);
        $dateStart->subSecond(3600);
        return $dateStart->toString('yyyy-MM-dd HH:mm:ss');
    }

    protected function _prepareDateTo($date)
    {
        $end = new Zend_Date($date, DateTime::DATE_INTERNAL_FORMAT);
        $dateEnd = new Zend_Date(date("Y-m-d", $end->getTimestamp()), DateTime::DATE_INTERNAL_FORMAT);
        $dateEnd->addDay(1)->subSecond(3600)->subMilliSecond(1);
        return $dateEnd->toString('yyyy-MM-dd HH:mm:ss');
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareColumns()
    {
//        $this->addColumn(
//            'period',
//            [
//                'header' => __('Interval'),
//                'index' => 'period',
//                'sortable' => false,
//                'period_type' => $this->getPeriodType(),
//                'renderer' => \Magento\Reports\Block\Adminhtml\Sales\Grid\Column\Renderer\Date::class,
//                'totals_label' => __('Total'),
//                'html_decorators' => ['nobr'],
//                'header_css_class' => 'col-period',
//                'column_css_class' => 'col-period'
//            ]
//        );

        $this->addColumn('id', [
            'header'=> __('Order Booking'),
            'type'  => 'number',
            'sortable'  => false,
            'index' => 'id',
            'total' => 'sum',
            'totals_label' => __('Total')
        ]);

        $this->addColumn('charge', [
            'header' => __('Charge'),
            'type' => 'number',
            'index' => 'charge',
            'total' => 'sum',
            'totals_label' => __('Total')
        ]);
        $this->addExportType('*/*/exportReturnItemsCsv', __('CSV'));
        $this->addExportType('*/*/exportReturnItemsExcel', __('Excel XML'));
        $this->addExportType('*/*/downloadPdfReturnItems', __('Download PDF'));

        return parent::_prepareColumns();
    }
}
