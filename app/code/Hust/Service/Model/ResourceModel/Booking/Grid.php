<?php

namespace Hust\Service\Model\ResourceModel\Booking;

use Hust\Service\Model\ResourceModel\Booking;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;
use Magento\Backend\Model\Auth\Session;

class Grid extends SearchResult
{
    protected $session;

    public function __construct(
        Session       $session,
        EntityFactory $entityFactory,
        Logger        $logger,
        FetchStrategy $fetchStrategy,
        EventManager  $eventManager,
                      $mainTable = 'hust_booking',
                      $resourceModel = Booking::class
    )
    {
        $this->session = $session;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    protected function _initSelect()
    {
        $locator_id = $this->getCurrentUser()->getData('locator_id');
        $this->addFilterToMap('booking_id', 'main_table.booking_id');
        // Join the 2nd Table
        if ($locator_id) {
            $select = $this->getSelect()->where('locator_id ='. $locator_id);
        } else {
            $select = $this->getSelect();
        }
        $select
            ->joinLeft(
                ['hust_booking_employee' => $this->getConnection()->getTableName('hust_booking_employee')],
                'main_table.booking_id = hust_booking_employee.booking_id',
                ['hust_booking_employee.employee_id']
            )->order("booking_status asc");

        parent::_initSelect();

        return $this;
    }

    public function getCurrentUser()
    {
        return $this->session->getUser();
    }
}
