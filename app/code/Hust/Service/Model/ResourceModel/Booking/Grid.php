<?php

namespace Hust\Service\Model\ResourceModel\Booking;

use Hust\Service\Model\ResourceModel\Booking;
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
                      $mainTable = 'hust_booking',
                      $resourceModel = Booking::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    protected function _initSelect()
    {
        $this->addFilterToMap('booking_id', 'main_table.booking_id');
        // Join the 2nd Table
          $this->getSelect()
            ->joinLeft(
                ['hust_booking_employee' => $this->getConnection()->getTableName('hust_booking_employee')],
                'main_table.booking_id = hust_booking_employee.booking_id',
                ['hust_booking_employee.employee_id']
            );
        parent::_initSelect();

        return $this;
    }
}
