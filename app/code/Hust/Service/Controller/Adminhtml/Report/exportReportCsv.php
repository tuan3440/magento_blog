<?php

namespace Hust\Service\Controller\Adminhtml\Report;

use Magento\Backend\Helper\Data as BackendHelper;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Reports\Controller\Adminhtml\Report\AbstractReport;
use Hust\Service\Block\Adminhtml\Report\Grid;
use Magento\Framework\App\Filesystem\DirectoryList;

class exportReportCsv extends AbstractReport
{
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter, TimezoneInterface $timezone, BackendHelper $backendHelperData = null)
    {
        parent::__construct($context, $fileFactory, $dateFilter, $timezone, $backendHelperData);
    }

    public function execute()
    {
        $fileName = 'reportReturnItems.csv';
        $grid = $this->_view->getLayout()->createBlock(Grid::class);
        $this->_initReportAction($grid);
        return $this->_fileFactory->create($fileName, $grid->getCsvFile(), DirectoryList::VAR_DIR);
    }
}
