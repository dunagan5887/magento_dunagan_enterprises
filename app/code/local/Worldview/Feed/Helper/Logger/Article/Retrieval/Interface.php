<?php
/**
 * Author: Sean Dunagan
 * Created: 4/11/15
 *
 * Interface Worldview_Feed_Helper_Logger_Article_Retrieval_Interface
 */

interface Worldview_Feed_Helper_Logger_Article_Retrieval_Interface
    extends Dunagan_Base_Helper_Processor_Logger_Interface
{
    // OPTIONAL

    // The following methods can optionally be overwritten by subclasses of Worldview_Feed_Helper_Logger_Article_Retrieval_Abstract

    /**
     * The message which should be logged for an article which was successfully persisted to the database
     *
     * @param string $source_code
     * @param Worldview_Source_Model_Source $persistedArticle
     * @return string - By default, the Worldview_Feed_Helper_Logger_Article_Retrieval_Abstract will return an empty string
     */
    public function getArticlePersistSuccessMessage($source_code, $persistedArticle);

    /**
     * The message which should be logged for an article which could not be persisted to the database due to an exception
     *
     * @param $article_link_and_exception_message_array
     * @param $source_name
     * @param $number_of_articles_with_exception
     * @return string - By default, the Worldview_Feed_Helper_Logger_Article_Retrieval_Abstract will return an string
     *                      templated by Worldview_Feed_Helper_Logger_Article_Retrieval_Abstract ERROR_ARTICLES_WITH_EXCEPTION
     */
    public function getArticlesWithExceptionsMessage($article_link_and_exception_message_array, $source_name, $number_of_articles_with_exception);
}
