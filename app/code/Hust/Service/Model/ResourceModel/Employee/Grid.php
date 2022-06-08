<?php

namespace Hust\Service\Model\ResourceModel\Employee;

use Hust\Service\Model\ResourceModel\Employee;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

class Grid extends SearchResult
{
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
                      $mainTable = 'hust_employee',
                      $resourceModel = Employee::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    protected function _initSelect()
    {
        $this->addFilterToMap('employee_id', 'main_table.employee_id');
        // Join the 2nd Table
        $this->getSelect()
            ->joinLeft(
                ['hust_employee_locator' => $this->getConnection()->getTableName('hust_employee_locator')],
                'main_table.employee_id = hust_employee_locator.employee_id',
                ['hust_employee_locator.locator_id']
            );
        parent::_initSelect();

        return $this;
    }
}
