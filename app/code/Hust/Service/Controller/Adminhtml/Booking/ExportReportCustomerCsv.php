<?php

namespace Hust\Service\Controller\Adminhtml\Booking;

use Magento\Reports\Controller\Adminhtml\Report\AbstractReport;
use Hust\Service\Block\Adminhtml\Customer\Grid;
use Magento\Framework\App\Filesystem\DirectoryList;

class ExportReportCustomerCsv extends AbstractReport
{
    public function execute()
    {
        $fileName = 'reportCustomerbooking.csv';
        $grid = $this->_view->getLayout()->createBlock(Grid::class);
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getCsvFile(), DirectoryList::VAR_DIR);
    }
}
