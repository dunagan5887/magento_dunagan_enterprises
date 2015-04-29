<?php
/**
 * Author: Sean Dunagan
 * Created: 4/28/15
 */

$installer = $this;

$installer->startSetup();

$guidance_books_tablename = $this->getTable('guidance_books/books');

$installer->getConnection()->dropTable($installer->getTable('guidance_books/books'));

$guidanceBooksTableObject =
    $installer->getConnection()
        ->newTable($guidance_books_tablename)
        ->addColumn(
            'book_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            11,
            array('nullable'  => false,
                'unsigned' => true,
                'primary' => true,
                'identity'  => true
            ),
            'Primary Key for the Table'
        )->addColumn(
            'isbn',
            // ISBN numbers are expected to be 10 or 13 digits: http://en.wikipedia.org/wiki/International_Standard_Book_Number
            Varien_Db_Ddl_Table::TYPE_BIGINT,
            11,
            array('nullable'  => false),
            'ISBN number of the book'
        )->addColumn(
            'title',
            Varien_Db_Ddl_Table::TYPE_VARCHAR,
            '255',
            array('nullable'  => false),
            'Title of the book'
        )->addColumn(
            'description',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            '',
            array('nullable'  => false),
            'Description of the book'
        )->addIndex(
            $installer->getIdxName('guidance_books/books', array('isbn')),
            array('isbn'),
            array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
        )->setComment('Table representing books modeling the Guidance Coding test');

$installer->getConnection()->createTable($guidanceBooksTableObject);

$installer->endSetup();
