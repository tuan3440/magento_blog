<?php
/**
 * @author VuThuan
 * @copyright Copyright (c) 2021 VuThuan
 */
namespace Dco\Service\Block\Adminhtml\Locator\Edit\Tab;

use Dco\Service\Model\LocatorFactory;
use Dco\Service\Model\ResourceModel\Service\CollectionFactory;
use Dco\Service\Model\Source\Status;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Registry;

class AvailableServices extends Extended
{
    /**
     * @var LocatorFactory
     */
    protected $locatorFactory;

    /**
     * @var CollectionFactory
     */
    protected $serviceCollectionFactory;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Visibility|mixed
     */
    protected $visibility;

    /**
     * @var Status|mixed
     */
    protected $status;

    public function __construct(
        Context $context,
        Data $backendHelper,
        Registry $registry,
        ObjectManagerInterface $objectManager,
        LocatorFactory $locatorFactory,
        CollectionFactory $serviceCollectionFactory,
        Visibility $visibility = null,
        Status $status = null,
        array $data = []
    ) {
        $this->locatorFactory = $locatorFactory;
        $this->serviceCollectionFactory = $serviceCollectionFactory;
        $this->_objectManager = $objectManager;
        $this->registry = $registry;
        $this->visibility = $visibility ?: ObjectManager::getInstance()->get(Visibility::class);
        $this->status = $status ?: ObjectManager::getInstance()->get(Status::class);
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('servicesGrid');
        $this->setDefaultSort('service_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('locator_id')) {
            $this->setDefaultFilter(['in_services' => 1]);
        }
    }

    protected function _prepareCollection()
    {
        $collection = $this->serviceCollectionFactory->create();
        $collection->addFieldToFilter('is_active', 1);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_services',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_services',
                'align' => 'center',
                'index' => 'service_id',
                'values' => $this->_getSelectedServices(),
            ]
        );

        $this->addColumn(
            'service_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'service_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'Name   ',
            [
                'header' => __('Name'),
                'index' => 'name',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name',
            ]
        );
        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => $this->status->toArray(),
                'header_css_class' => 'col-status',
                'column_css_class' => 'col-status',
            ]
        );

//        $this->addColumn('position', [
//            'header' => __('Position'),
//            'name' => 'position',
//            'width' => 60,
//            'type' => 'number',
//            'validate_class' => 'validate-number',
//            'index' => 'position',
//            'editable' => true,
//        ]);

        return $this;
    }


    /**
     * @param Column $column
     * @return $this|AvailableServices
     * @throws LocalizedException
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_services') {
            $serviceIds = $this->_getSelectedServices();

            if (empty($serviceIds)) {
                $serviceIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('service_id', ['in' => $serviceIds]);
            } else {
                if ($serviceIds) {
                    $this->getCollection()->addFieldToFilter('service_id', ['nin' => $serviceIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/availableservicesgrid', ['_current' => true]);
    }

    public function getRowUrl($row)
    {
        return '';
    }


    protected function _getSelectedServices()
    {
        $locator = $this->getLocator();
        return $locator->getServices($locator);
    }

    public function getSelectedServices()
    {
        $locator = $this->getLocator();
        return $locator->getServices($locator);
//        $locator = $this->getLocator();
//        $selected = $locator->getServices($locator);
//        $services = [];
//        foreach ($selected as $service) {
//            $services[$service['service_id']] = $service;
//        }
//        if (!is_array($services)) {
//            $services = [];
//        }
//        return $services;
    }

    protected function getLocator()
    {
        $storeId = $this->getRequest()->getParam('locator_id');
        $store = $this->locatorFactory->create();
        if ($storeId) {
            $store->load($storeId);
        }
        return $store;
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return true;
    }
}
