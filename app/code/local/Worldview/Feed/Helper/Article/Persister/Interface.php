<?php
/**
 * Author: Sean Dunagan
 * Created: 4/10/15
 *
 * interface Worldview_Feed_Helper_Article_Persister_Interface
 */

interface Worldview_Feed_Helper_Article_Persister_Interface
{
    /**
     * Takes an array of raw article data and persists articles in the database if they
     * are not already recorded in the database
     *
     * @param array $processed_article_data_by_source_code_array - array of processed article feed data
     * @param Worldview_Source_Model_Mysql4_Source_Collection - Collection of feed sources which data was pulled from
     * @return Worldview_Feed_Helper_Article_Persister_Result - An object which will contain data regarding
     *                                                           which articles were persisted, and how
     *                                                           many were already in the database
     */
    public function persistArticles(array $processed_article_data_by_source_code_array,
                                        Worldview_Source_Model_Mysql4_Source_Collection $sourceCollection);
}
