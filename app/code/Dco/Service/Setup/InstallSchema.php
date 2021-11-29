<?php
namespace Dco\Service\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;
// vaccine -> spa
/**
 * Class InstallSchema
 * @package Dco\Service\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $serviceTable = $installer->getTable("spa_service");
        $locatorTable = $installer->getTable("spa_locator");
        $locatorService = $installer->getTable("spa_store_service_locator");

        $table = $installer->getConnection()->newTable(
            $serviceTable
        )->addColumn(
            'service_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Service Id'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Name'
        )->addColumn(
            'image',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false],
            'Image'
        )->addColumn(
            'short_description',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true, 'default' => null],
            'Short Description'
        )->addColumn(
            'content',
            Table::TYPE_TEXT,
            null,
            ['nullable' => false],
            'content'
        )->addColumn(
            'price_service',
            Table::TYPE_FLOAT,
            null,
            ['nullable' => false],
            'content'
        )->addColumn(
            'is_active',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Active'
        )->addColumn(
            'position',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => true, 'default' => null],
            'Position'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Updated At'
        )->addIndex(
            $installer->getIdxName(
                $serviceTable,
                ['service_id']
            ),
            ['service_id']
        );

        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
            $locatorTable
        )->addColumn(
            'locator_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Store Id'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => null],
            'Name'
        )->addColumn(
            'address',
            Table::TYPE_TEXT,
            512,
            ['nullable' => true, 'default' => null],
            'Address'
        )->addColumn(
            'city',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true, 'default' => null],
            'City'
        )->addColumn(
            'country',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true, 'default' => null],
            'Country'
        )->addColumn(
            'phone',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => null],
            'Phone'
        )->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => null],
            'Email'
        )->addColumn(
            'is_active',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Active'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Updated At'
        )->addIndex(
            $installer->getIdxName(
                $locatorTable,
                ['locator_id']
            ),
            ['locator_id']
        );

        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()->newTable(
            $locatorService
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Id'
        )->addColumn(
            'service_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default'],
            'Service Id'
        )->addColumn(
            'locator_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default'],
            'Locator Id'
        )->addForeignKey(
            $installer->getFkName($locatorService, 'service_id', $serviceTable, 'service_id'),
            'service_id',
            $serviceTable,
            'service_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName($locatorService, 'locator_id', $locatorTable, 'locator_id'),
            'locator_id',
            $locatorTable,
            'locator_id',
            Table::ACTION_CASCADE
        );

        $installer->getConnection()->createTable($table);
    }
}
