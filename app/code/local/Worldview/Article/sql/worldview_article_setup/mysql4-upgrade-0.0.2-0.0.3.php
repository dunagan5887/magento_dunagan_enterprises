<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 7:42 PM
 */

$installer = $this;
$installer->startSetup();

$table_name = $installer->getTable('worldview_article/entity');

$installer->getConnection()->addColumn($table_name, 'publication_date', 'DATETIME DEFAULT NULL');

$installer->getConnection()->addIndex(
    $table_name,
    $installer->getIdxName('worldview_article/entity', array('publication_date')),
    array('publication_date'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
);

$installer->getConnection()->addColumn($table_name, 'author', 'VARCHAR(100) DEFAULT ""');
$installer->getConnection()->addColumn($table_name, 'description', 'TEXT DEFAULT ""');
