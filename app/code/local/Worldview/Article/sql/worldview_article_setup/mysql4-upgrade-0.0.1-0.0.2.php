<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 7:42 PM
 */

$installer = $this;
$installer->startSetup();

$table_name = $installer->getTable('worldview_article/entity');

$installer->getConnection()->addColumn($table_name, 'is_biased', 'tinyint(1) DEFAULT 0');

$installer->getConnection()->addIndex(
    $table_name,
    $installer->getIdxName('worldview_article/entity', array('is_biased')),
    array('is_biased'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
);
