<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 7:42 PM
 */

$installer = $this;
$installer->startSetup();

$table_name = $installer->getTable('worldview_article/entity');

$installer->getConnection()->addColumn($table_name, 'link', 'varchar(700) NOT NULL');

$installer->getConnection()->addIndex(
    $table_name,
    $installer->getIdxName('worldview_article/entity', array('link')),
    array('link'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
);

