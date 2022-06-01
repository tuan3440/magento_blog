<?php

namespace Hust\Service\Controller\Adminhtml\EmployeeReport;

use Hust\Service\Block\Adminhtml\EmployeeReport\Grid;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Reports\Controller\Adminhtml\Report\AbstractReport;

class ExportReportEmployeeExcel extends AbstractReport
{
    public function execute()
    {
        $fileName = 'reportReportBooking.xlsx';
        $grid = $this->_view->getLayout()->createBlock(Grid::class);
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getExcelFile(), DirectoryList::VAR_DIR);
    }
}
