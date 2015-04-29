<?php
/**
 * Author: Sean Dunagan
 * Created: 4/28/15
 */

class Guidance_Books_Block_Index extends Mage_Core_Block_Template
{
    protected $_booksHelper = null;

    public function getAnchorJumpLinkName($capital_letter)
    {
        return ('books_index_' . $capital_letter);
    }
    
    public function getLetterToBooksMappingArray()
    {
        return $this->_getBooksHelper()->getLetterToBooksMappingArray();
    }

    public function getCapitalizedAlphabet()
    {
        return $this->_getBooksHelper()->getCapitalizedAlphabet();
    }

    public function getViewBookLink($bookObject)
    {
        return $this->_getBooksHelper()->getViewBookLink($bookObject);
    }

    protected function _getBooksHelper()
    {
        if (is_null($this->_booksHelper))
        {
            $this->_booksHelper = Mage::helper('guidance_books');
        }

        return $this->_booksHelper;
    }
}
