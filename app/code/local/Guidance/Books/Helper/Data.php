<?php
/**
 * Author: Sean Dunagan
 * Created: 4/28/15
 */

class Guidance_Books_Helper_Data extends Mage_Core_Helper_Data
{
    public function getViewBookLink(Guidance_Books_Model_Book $bookObject)
    {
        return $this->_getUrl('guidancebooks/index/view', array('isbn' => $bookObject->getIsbn()));
    }

    public function getLetterToBooksMappingArray()
    {
        $bookCollection = $this->getBookCollection();
        $bookCollection->addOrder('title', Zend_Db_Select::SQL_ASC);

        $letters_to_books_map = array();
        foreach ($bookCollection->getItems() as $bookModel)
        {
            $book_title = $bookModel->getTitle();
            $first_char_of_title = substr(ucfirst($book_title), 0, 1);
            if (!isset($letters_to_books_map[$first_char_of_title]))
            {
                $letters_to_books_map[$first_char_of_title] = array();
            }
            $letters_to_books_map[$first_char_of_title][] = $bookModel;
        }

        return $letters_to_books_map;
    }

    public function getCapitalizedAlphabet()
    {
        return range('A', 'Z');
    }

    public function getBookCollection()
    {
        $booksCollection = Mage::getModel('guidance_books/book')->getCollection();
        return $booksCollection;
    }
}
