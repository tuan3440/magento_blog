<?php

namespace Hust\Service\Block\Adminhtml\EmployeeReport;

use Hust\Service\Block\Adminhtml\Grid\Columns\Renderer\Employee;
use Hust\Service\Block\Adminhtml\Grid\Columns\Renderer\Service;
use Magento\Framework\App\ObjectManager;
use Hust\Service\Model\ResourceModel\BookingSale\CollectionFactory;
use Magento\Backend\Model\Auth\Session;


class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $collection;
    protected $session;

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
        Session       $session,
        array $data = []
    ) {
        $this->session = $session;
        $this->collection = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _prepareCollection()
    {
        $locator_id = $this->getCurrentUser()->getData('locator_id');

        $collection = $this->collection->create()->addFieldToFilter("locator_id", $locator_id);
        $collection->getSelect()->group(['employee_id', 'service_id'])->columns([
            'count' => 'count(*)'
        ]);
//        echo $collection->getSelect()->__toString();
//        die;
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    public function getCurrentUser()
    {
        return $this->session->getUser();
    }

    /**
     * Prepare grid columns
     *
     * @return \Hust\Service\Block\Adminhtml\Customer\Grid
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('date', [
            'header' => __('Date'),
            'type' => 'date',
            'index' => 'date'
        ]);

        $this->addColumn('employee_id', [
            'header' => __('Employee'),
            'type' => 'text',
            'index' => 'employee_id',
            'renderer' => Employee::class
        ]);

        $this->addColumn('service_id', [
            'header' => __('Service'),
            'type' => 'text',
            'index' => 'service_id',
            'renderer' => Service::class,
        ]);

        $this->addColumn(
            'count',
            [
                'header' => __('Numbers service'),
                'index' => 'count',
                'filter' => false
            ]
        );

        $this->addExportType('*/employeereport/exportReportEmployeeCsv', __('CSV'));
        $this->addExportType('*/employeereport/exportReportEmployeeExcel', __('Excel XML'));
        return $this;
    }
}

