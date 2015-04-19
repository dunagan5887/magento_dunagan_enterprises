<?php
/**
 * Author: Sean Dunagan
 * Created: 4/10/15
 */

interface Worldview_Source_Helper_Raw_Data_Processor_Interface
    extends Dunagan_Base_Model_Delegate_Interface
{
    /**
     * This method takes an array. Each index of the array should be an array representing
     * the data fields of a feed item. This method should convert the raw data fields
     * into standard fields which the rest of the application recognizes and can act on.
     *
     * @param $raw_feed_source_article_set
     * @return array - An array of the following form
     *          array(
     *              0 => array('title' => 'title of article',
     *                          'link' => 'url defining the webpage of the article',
     *                          'article_text' => 'the text of the article'
     *                          ...
     *                          ...),
     *              1 => array('title' => 'title of article',
     *                              'link' => 'url defining the webpage of the article',
     *                          'article_text' => 'the text of the article'
     *                          ...
     *                          ...),
     *              ...
     *              ...
     */
    public function processRawArticleData(array $raw_feed_source_article_set);

    /**
     * This method takes an array containing the raw article data returned from a feed.
     * It should return the article's text, taken from the article's webpage
     *
     * @param array $raw_article_data
     * @return string
     */
    public function scrapeArticleData(array $raw_article_data);
}
