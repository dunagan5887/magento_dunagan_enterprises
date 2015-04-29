<?php
/**
 * Author: Sean Dunagan
 * Created: 4/28/15
 * Class Guidance_Books_Model_Mysql4_Book_Collection
 */

class Guidance_Books_Model_Mysql4_Book_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('guidance_books/book');
    }
}
