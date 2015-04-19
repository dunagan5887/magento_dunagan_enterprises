<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 5:50 PM
 */

$installer = $this;
$installer->startSetup();

// Drop table if it already exists
$installer->getConnection()->dropTable($installer->getTable('worldview_source/entity'));

$feedSourceEntityTable =
    $installer->getConnection()
        ->newTable($installer->getTable('worldview_source/entity'))
        ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        11,
        array('nullable'  => false,
            'unsigned' => true,
            'primary' => true,
            'identity'  => true
        ),
        'Primary Key for the Table'
    )->addColumn(
        'active',
        Varien_Db_Ddl_Table::TYPE_TINYINT,
        1,
        array('nullable'  => false),
        'Flag denoting whether feed should be processed'
    )->addColumn(
        'code',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        30,
        array('nullable'  => false),
        'Feed Source Code'
    )->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        100,
        array('nullable'  => false),
        'Feed Source Name'
    )->addColumn(
        'feed_url',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        500,
        array('nullable'  => false),
        'Feed Url'
    )->addColumn(
        'category',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        20,
        array('nullable'  => false),
        'Feed Source Category'
    )->addColumn(
        'type',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        20,
        array('nullable'  => false),
        'Feed Source Type e.g. RSS'
    )->addColumn(
        'raw_data_processor',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        150,
        array('nullable'  => false),
        'The model used to convert raw feed data into article data fields'
    )->addIndex(
        $installer->getIdxName('worldview_source/entity', array('code')),
        array('code'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )->addIndex(
        $installer->getIdxName('worldview_source/entity', array('active')),
        array('active'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
    )->setComment('Entity table for the feed sources');

$installer->getConnection()->createTable($feedSourceEntityTable);
