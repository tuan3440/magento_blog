<?php

namespace Hust\Service\Controller\Adminhtml\EmployeeReport;

use Hust\Service\Block\Adminhtml\EmployeeReport\Grid;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Reports\Controller\Adminhtml\Report\AbstractReport;

class ExportReportEmployeeCsv extends AbstractReport
{
    public function execute()
    {
        $fileName = 'reportEmployeebooking.csv';
        $grid = $this->_view->getLayout()->createBlock(Grid::class);
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getCsvFile(), DirectoryList::VAR_DIR);
    }
}
