<?php

/**
 * Author: Sean Dunagan
 * Created: 4/28/15
 * Class Guidance_Books_Model_Book
 */

class Guidance_Books_Model_Book extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('guidance_books/book');
    }
}
