<?php
/**
 * Author: Sean Dunagan
 * Created: 4/28/15
 */

$data_to_insert = array(
    array(
        'isbn' => '1234567890',
        'title' => 'Every Dog Has His Day',
        'description' => 'Book about the day where things work out'
    ),
    array(
        'isbn' => '2234567890',
        'title' => 'Mississippi Blues',
        'description' => 'Sounds like a book about how life is tough down South'
    ),
    array(
        'isbn' => '3234567890',
        'title' => 'Moby Dick',
        'description' => 'When obsession meets nature'
    ),
    array(
        'isbn' => '4234567890',
        'title' => 'Mug Shot',
        'description' => 'Likely a book about the best celebrity pictures available'
    ),
    array(
        'isbn' => '5234567890',
        'title' => 'Sample Book Title',
        'description' => 'Sample Book Description'
    ),
    array(
        'isbn' => '6234567890',
        'title' => 'Show Me The Way',
        'description' => 'The state book of Missouri?'
    )
);

foreach ($data_to_insert as $book_data)
{
    try
    {
        $bookModel = Mage::getModel('guidance_books/book');
        $bookModel->setData($book_data);
        $bookModel->save();
    }
    catch(Exception $e)
    {
        Mage::logException($e);
    }
}
