<?php

namespace Hust\Service\Block\Adminhtml\Locator\Edit\Tab;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Hust\Service\Model\LocatorFactory;
use Hust\Service\Model\ServiceRegistry;
use Hust\Service\Model\ResourceModel\Service\CollectionFactory;
use Hust\Service\Model\Source\ServiceStatus;

class AvailableServices extends Extended implements TabInterface
{
    protected $collectionFactory;
    protected $locatorFactory;
    protected $serviceRegistry;
    protected $status;
    public function __construct(\Magento\Backend\Block\Template\Context $context,
                                \Magento\Backend\Helper\Data $backendHelper,
                                CollectionFactory $collectionFactory,
                                ServiceRegistry $serviceRegistry,
                                LocatorFactory $locatorFactory,
                                ServiceStatus $serviceStatus,
                                array $data = [])
    {
        $this->locatorFactory = $locatorFactory;
        $this->serviceRegistry = $serviceRegistry;
        $this->collectionFactory = $collectionFactory;
        $this->status = $serviceStatus;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('service_grid');
        $this->setDefaultSort('service_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('locator_id')) {
            $this->setDefaultFilter(['in_services' => 1]);
        }
    }

    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create()->addFieldToFilter('is_active', 1);
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
                'name' => 'in_service',
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

        $this->addColumn('slot', [
            'header' => __('Slot'),
            'name' => 'slot',
            'width' => 60,
            'type' => 'number',
            'validate_class' => 'validate-number',
            'index' => 'slot',
            'editable' => true,
        ]);
//        $this->addColumn(
//            'is_active',
//            [
//                'header' => __('Status'),
//                'index' => 'is_active',
//                'type' => 'options',
//                'options' => $this->status->toArray(),
//                'header_css_class' => 'col-status',
//                'column_css_class' => 'col-status',
//            ]
//        );

        return $this;
    }

    protected function _getSelectedServices()
    {
        $services = $this->getLocatorServices();
        if (!is_array($services)) {
            $services = array_keys($this->getSelectedServices());
        }
        return $services;
    }

    /**
     * Retrieve related products
     *
     * @return array
     */
    public function getSelectedServices()
    {
        $services = [];
//        foreach ($this->_coreRegistry->registry('current_product')->getRelatedProducts() as $product) {
//            $products[$product->getId()] = ['position' => $product->getPosition()];
//        }
//        return $products;
        $locator = $this->getLocator();
        $selected = $locator->getServicesWithPosition($locator);
        foreach ($selected as $service) {
            $services[$service['service_id']] = ['service_id' => $service['service_id']];
        }
        return $services;
    }

//    protected function _getSelectedServices()
//    {
//        $locator = $this->getLocator();
//        return $locator->getServices($locator);
//        $services = $this->getLocatorServices();
//        if (!$services) {
//            $services = array_keys($this->getSelectedServices());
//            return $services;
//        }
//        return $services;
//    }

//    public function getSelectedServices()
//    {
//        $locator = $this->getLocator();
//        $selected = $locator->getServicesWithPosition($locator);
//        return $selected;
//    }

    protected function getLocator()
    {
        $locatorId = $this->getRequest()->getParam('locator_id');
        $locator = $this->locatorFactory->create();
        if ($locatorId) {
            $locator->load($locatorId);
        }
        return $locator;
    }

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

    public function getTabLabel()
    {
        // TODO: Implement getTabLabel() method.
    }

    public function getTabTitle()
    {
        // TODO: Implement getTabTitle() method.
    }

    public function canShowTab()
    {
        // TODO: Implement canShowTab() method.
    }

    public function isHidden()
    {
        // TODO: Implement isHidden() method.
    }
}
