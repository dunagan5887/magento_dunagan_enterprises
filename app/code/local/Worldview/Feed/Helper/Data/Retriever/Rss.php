<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * Class Worldview_Feed_Helper_Data_Retriever_Rss
 */

class Worldview_Feed_Helper_Data_Retriever_Rss
    extends Worldview_Feed_Helper_Data_Retriever_Abstract
    implements Worldview_Feed_Helper_Data_Retriever_Interface
{
    const ERROR_RSS_FEED_DID_NOT_PRODUCE_XML_OBJECT = 'No xml object was produced when trying to load RSS source feed %s from url %s';
    const EXCEPTION_PROCESSING_RSS_FEED = 'An exception while trying to process RSS feed source with code %s: %s';

    public function retrieveDataFromSourceCollection(Worldview_Source_Model_Mysql4_Source_Collection $sourceCollection)
    {
        $array_of_data_to_return = array();

        foreach ($sourceCollection as $feedSource)
        {
            $feed_source_code = $feedSource->getCode();
            $raw_feed_source_article_set = array();

            try
            {
                $rss_url = $feedSource->getFeedUrl();
                $rss_xml_object = simplexml_load_file($rss_url);

                if (!is_object($rss_xml_object) || !is_object($rss_xml_object->channel))
                {
                    // TODO TEST THIS
                    $error_message = sprintf(self::ERROR_RSS_FEED_DID_NOT_PRODUCE_XML_OBJECT, $feed_source_code, $rss_url);
                    $this->logErrorMessageWithProcessModel($feed_source_code, $error_message);
                    Mage::log($error_message);
                    $exceptionToLog = new Exception($error_message);
                    Mage::logException($exceptionToLog);
                    // Continue on to next feed source
                    continue;
                }

                foreach($rss_xml_object->channel->item as $item)
                {
                    try
                    {
                        // Ensure that the $item object contains a link
                        if (!isset($item->link) || empty($item->link))
                        {
                            continue;
                        }

                        // Ensure that the $item object contains a title before querying to see if this article has already been retrieved
                        if (!isset($item->title) || empty($item->title))
                        {
                            continue;
                        }

                        $article_data_array = array();
                        foreach ($item->children() as $field => $value)
                        {
                            // TODO ensure that $value is of type SimpleXMLElement
                            $article_data_array[$field] = $value->__toString();
                        }

                        $raw_feed_source_article_set[] = $article_data_array;
                    }
                    catch(Exception $e)
                    {
                        // Assume a malformed response for this item and continue
                    }
                }
            }
            catch(Exception $e)
            {
                $error_message = sprintf(self::EXCEPTION_PROCESSING_RSS_FEED, $feedSource->getSource(), $e->getMessage());
                Mage::log($error_message);
                $exceptionToLog = new Exception($error_message);
                Mage::logException($exceptionToLog);
            }

            $processed_feed_article_set = $this->_processRawFeedData($feedSource, $raw_feed_source_article_set);
            $array_of_data_to_return[$feed_source_code] = $processed_feed_article_set;
        }

        return $array_of_data_to_return;
    }

    protected function _processRawFeedData(Worldview_Source_Model_Source $feedSource, array $raw_feed_source_article_set)
    {
        $rawArticleDataProcessor = $feedSource->getRawDataProcessor();
        $raw_article_processing_return = $rawArticleDataProcessor->processRawArticleData($raw_feed_source_article_set);
        $processed_article_data_array = $raw_article_processing_return['processed_article_data_array'];
        $exceptions_during_articles_processing = $raw_article_processing_return['exceptions_during_articles_processing'];

        foreach ($exceptions_during_articles_processing as $exception_message)
        {
            $this->logErrorMessageWithProcessModel($feedSource->getCode(), $exception_message);
        }

        return $processed_article_data_array;
    }

    public function logErrorMessageWithProcessModel($source_code, $error_message)
    {
        $processModel = $this->getDelegator();
        $processModel->getDelegate('process_logger')
                        ->logErrorRegardingSourceFeed($source_code, $error_message);
    }
}
