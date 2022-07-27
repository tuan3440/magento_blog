<?php

namespace Hust\Service\Block\Adminhtml\Report;

use Magento\Backend\Block\Widget\Grid\Extended;
use Zend_Date;
use Hust\Service\Model\ResourceModel\BookingSale\CollectionFactory;
use Hust\Service\Model\ResourceModel\BookingSale;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\DataObject;
use Zend_Db_Expr;
use Zend_Db_Select;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_collectionFactory;
    protected $resource;
    protected $_columnGroupBy = 'period';

//    public function __construct(
//        \Magento\Backend\Block\Template\Context $context,
//        \Magento\Backend\Helper\Data $backendHelper,
//        \Magento\Reports\Model\ResourceModel\Report\Collection\Factory $resourceFactory,
//        \Magento\Reports\Model\Grouped\CollectionFactory $collectionFactory,
//        \Magento\Reports\Helper\Data $reportsData,
//        CollectionFactory $collection,
//        BookingSale $resource,
//        array $data = [])
//    {
//        $this->resource = $resource;
//        $this->_collectionFactory = $collection;
//        parent::__construct($context, $backendHelper, $resourceFactory, $collectionFactory, $reportsData, $data);
//    }
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        CollectionFactory $collection,
        BookingSale $resource,
        array $data = [])
    {
        $this->resource = $resource;
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
        if ($params && $params->getData()) {
            $period = $params->getPeriodType();
            $from = $params->getFrom();
            $to = $params->getTo();
            $from = $this->_prepareDateFrom($from);
            $to = $this->_prepareDateTo($to);
            $collection->addFieldToFilter('date', ['from' => $from , 'to' => $to]);

            switch ($period) {
                case 'day':
                    $collection->getSelect()->group('concat(day(date), month(date), year(date))');
                    break;
                case 'month':
                    $collection->getSelect()->group('concat(month(date), year(date))');
                    break;
                case 'year':
                    $collection->getSelect()->group('concat(year(date))');
                    break;
            }
            if ($locator = $params->getLocatorId()) {
                $collection->addFieldToFilter('locator_id', ['in' => $locator]);
            }
            if ($service = $params->getServiceId()) {
                $collection->addFieldToFilter('service_id', ['in' => $service]);
            }
            $collection->getSelect()->columns([
                'charge' => new Zend_Db_Expr('SUM(charge)'),
            ]);
        }
        else {
            $collection->getSelect()->where('main_table.id =?', 0);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareDateFrom($date)
    {
        $start = new Zend_Date($date, DateTime::DATE_INTERNAL_FORMAT);
        $dateStart = new Zend_Date(date("Y-m-d", $start->getTimestamp()), DateTime::DATE_INTERNAL_FORMAT);
        $dateStart->subSecond(3600);
        return $dateStart->toString('yyyy-MM-dd');
    }

    protected function _prepareDateTo($date)
    {
        $end = new Zend_Date($date, DateTime::DATE_INTERNAL_FORMAT);
        $dateEnd = new Zend_Date(date("Y-m-d", $end->getTimestamp()), DateTime::DATE_INTERNAL_FORMAT);
        $dateEnd->addDay(1)->subSecond(3600)->subMilliSecond(1);
        return $dateEnd->toString('yyyy-MM-dd');
    }

    public function getCountTotals()
    {
        $collection = $this->_collectionFactory->create();
        if (!$this->getTotals()) {
            $params = $this->getFilterData();
            if ($params && $params->getData()) {
                $period = $params->getPeriodType();
                $from = $params->getFrom();
                $to = $params->getTo();
                $from = $this->_prepareDateFrom($from);
                $to = $this->_prepareDateTo($to);
                $collection->addFieldToFilter('date', ['from' => $from, 'to' => $to]);

                if ($locator = $params->getLocatorId()) {
                    $collection->addFieldToFilter('locator_id', ['in' => $locator]);
                }
                if ($service = $params->getServiceId()) {
                    $collection->addFieldToFilter('service_id', ['in' => $service]);
                }
//            echo $collection->getSelect()->__toString();
//            die;
            } else {
                $collection->getSelect()->where('main_table.id =?', 0);
            }

            $read = $this->resource->getConnection();

            if ($collection->getSize() < 1 || !$params->getData('from')) {
                $this->setTotals(new DataObject());
            } else {
                $ret = $collection->getSelect();
                $ret->reset(Zend_Db_Select::COLUMNS);
                $ret->reset(Zend_Db_Select::LIMIT_COUNT);
                $ret->reset(Zend_Db_Select::LIMIT_OFFSET);
                $ret->columns([
                    'charge' => new Zend_Db_Expr('SUM(charge)'),
                    'id' => new Zend_Db_Expr('count(*)')
                ]);
//                echo $ret->__toString();
//                die;
                $data = $read->fetchAssoc($ret);
                foreach ($data as $item) {
                    $items = new DataObject();
                    $items->addData($item);
                    $this->setTotals($items);
                }
            }
            return parent::getCountTotals();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'date',
            [
                'header' => __('Interval'),
                'index' => 'date',
                'sortable' => false,
                'period_type' => $this->getPeriodType(),
                'renderer' => \Magento\Reports\Block\Adminhtml\Sales\Grid\Column\Renderer\Date::class,
                'totals_label' => __('Total'),
                'html_decorators' => ['nobr'],
                'header_css_class' => 'col-period',
                'column_css_class' => 'col-period'
            ]
        );

        $this->addColumn('charge', [
            'header' => __('Charge($)'),
            'type' => 'number',
            'index' => 'charge',
        ]);
        $this->addExportType('*/*/exportReportCsv', __('CSV'));
        $this->addExportType('*/*/exportReportExcel', __('Excel XML'));
//        $this->addExportType('*/*/downloadPdfReturnItems', __('Download PDF'));

        return parent::_prepareColumns();
    }
}
