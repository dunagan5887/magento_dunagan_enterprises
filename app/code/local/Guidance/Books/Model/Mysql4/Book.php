<?php

/**
 * Author: Sean Dunagan
 * Created: 4/28/15
 * Class Guidance_Books_Model_Mysql4_Book
 */

class Guidance_Books_Model_Mysql4_Book extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('guidance_books/books','book_id');
    }
}
