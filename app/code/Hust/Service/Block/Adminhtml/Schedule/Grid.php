<?php

namespace Hust\Service\Block\Adminhtml\Schedule;

use Hust\Service\Model\ResourceModel\Booking\CollectionFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Stdlib\DateTime;
use Zend_Date;
use Hust\Service\Block\Adminhtml\Grid\Columns\Renderer\Service;
use Hust\Service\Block\Adminhtml\Grid\Columns\Renderer\Hour;
use Hust\Service\Block\Adminhtml\Grid\Columns\Renderer\Employee;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_collectionFactory;
    protected $resource;
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
        $this->setFilterVisibility(true);
        $this->setPagerVisibility(true);
        $this->setCountTotals(false);
        if (isset($this->_columnGroupBy)) {
            $this->isColumnGrouped($this->_columnGroupBy, true);
        }
        $this->setEmptyCellLabel(__('We can\'t find records for this period.'));
    }

    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create()
            ->addFieldToFilter('booking_status', 1);
        $collection->getSelect()->joinLeft(
            ['hust_booking_employee' => $collection->getTable('hust_booking_employee')],
            'main_table.booking_id = hust_booking_employee.booking_id',
            ['hust_booking_employee.employee_id']);


        $params = $this->getFilterData();
        if ($params && $params->getData()) {
            $date = $params->getDate();
            $date = $this->_prepareDateTo($date);
            $collection->addFieldToFilter('date', $date);

            if ($locator = $params->getLocatorId()) {
                $collection->addFieldToFilter('locator_id', ['in' => $locator]);
            }

        }
        else {
            $collection->getSelect()->where('main_table.booking_id =?', 0);
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


    protected function _prepareDateTo($date)
    {
        $end = new Zend_Date($date, DateTime::DATE_INTERNAL_FORMAT);
        $dateEnd = new Zend_Date(date("Y-m-d", $end->getTimestamp()), DateTime::DATE_INTERNAL_FORMAT);
//        $dateEnd->addDay(1)->subSecond(3600)->subMilliSecond(1);
        return $dateEnd->toString('yyyy-MM-dd');
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareColumns()
    {

        $this->addColumn('booking_id', [
            'header'=> __('Booking'),
            'type'  => 'number',
            'sortable'  => false,
            'index' => 'booking_id',
        ]);

        $this->addColumn('service_id', [
            'header' => __('Service'),
            'type' => 'text',
            'index' => 'service_id',
            'renderer' => Service::class,
        ]);

        $this->addColumn('booking_hour', [
            'header' => __('Hour'),
            'type' => 'text',
            'index' => 'booking_hour',
            'renderer' => Hour::class,
        ]);

        $this->addColumn('employee_id', [
            'header' => __('Employee'),
            'type' => 'text',
            'index' => 'employee_id',
            'renderer' => Employee::class
        ]);

        return parent::_prepareColumns();
    }
}
