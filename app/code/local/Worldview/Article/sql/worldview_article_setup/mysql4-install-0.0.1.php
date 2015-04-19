<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 7:42 PM
 */

$installer = $this;
$installer->startSetup();

// Drop table if it already exists
$installer->getConnection()->dropTable($installer->getTable('worldview_article/entity'));

$articleEntityTable =
    $installer->getConnection()
        ->newTable($installer->getTable('worldview_article/entity'))
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
        'feed_source_id',
        Varien_Db_Ddl_Table::TYPE_TINYINT,
        1,
        array('nullable'  => false),
        'Id of the feed where the article came from'
    )->addColumn(
        'title',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        200,
        array('nullable'  => false),
        'Title of the article'
    )->addColumn(
        'article_text',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        10000,
        array('nullable'  => false),
        'The text of the article'
    )->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        null,
        array('nullable' => false),
        'Time article was written (or retrieved if date is unavailable)'
    )->addIndex(
        $installer->getIdxName('worldview_article/entity', array('feed_source_id')),
        array('feed_source_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX)
    )->addForeignKey(
        $installer->getFkName('worldview_article/entity', 'feed_source_id', 'worldview_source/entity', 'entity_id'),
        'feed_source_id',
        $installer->getTable('worldview_source/entity'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )->setComment('Entity Table for articles');

$installer->getConnection()->createTable($articleEntityTable);
