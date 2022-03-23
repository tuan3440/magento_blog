<?php

namespace Hust\Service\Controller\Adminhtml\Report;

use Hust\Service\Block\Adminhtml\Report\Grid;
use Magento\Backend\Helper\Data as BackendHelper;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Reports\Controller\Adminhtml\Report\AbstractReport;

class exportReportExcel extends AbstractReport
{
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter, TimezoneInterface $timezone, BackendHelper $backendHelperData = null)
    {
        parent::__construct($context, $fileFactory, $dateFilter, $timezone, $backendHelperData);
    }

    public function execute()
    {
        $fileName = 'reportBooking.xlsx';
        $grid = $this->_view->getLayout()->createBlock(Grid::class);
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getExcelFile(), DirectoryList::VAR_DIR);
    }
}

