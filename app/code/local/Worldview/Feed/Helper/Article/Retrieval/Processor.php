<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 8:21 PM
 *
 * class Worldview_Feed_Helper_Retrieval_Processor
 *
 * This Helper has the task of retrieving feed data from feed sources. This involves the following steps:
 *
 *  1. Loading all "active" sources in the database
 *  2. Gathering all data possible from those sources
 *  3. Creating Articles objects from those sources and persisting them into the database
 *  4. Reporting what articles were retrieved from which sources during the feed's process
 *
 * This helper will make use of the delegate software pattern to delegate these responsibilities to delegate helper classes
 */
class Worldview_Feed_Helper_Article_Retrieval_Processor
    extends Worldview_Feed_Helper_Processor
{
    const RETRIEVAL_PROCESS_CLASSNAME_CONFIG = 'article_retrieval';
    const SOURCE_LOADER_DELEGATE_CODE = 'source_loader';
    const DATA_RETRIEVAL_DELEGATE_CODE = 'data_retriever';
    const ARTICLE_PERSISTER_DELEGATE_CODE = 'article_persister';
    const PROCESS_LOGGER_DELEGATE_CODE = 'process_logger';

    protected function _getProcessConfigurationSubPath()
    {
        return self::RETRIEVAL_PROCESS_CLASSNAME_CONFIG;
    }

    public function getProcessModelClassname()
    {
        return 'worldview_feed/process_article_retrieval';
    }

    public function executeProcess($process_code, Dunagan_Base_Model_Process_Interface $processModelToProcess)
    {
        $sourceLoaderDelegate = $processModelToProcess->getDelegate(self::SOURCE_LOADER_DELEGATE_CODE);
        // TODO Check for correct interface for $sourceLoaderDelegate
        $sourceCollection = $sourceLoaderDelegate->loadSourceCollection();

        $dataRetrievalDelegate = $processModelToProcess->getDelegate(self::DATA_RETRIEVAL_DELEGATE_CODE);
        // TODO Check for correct interface for $dataRetrievalDelegate
        $processed_article_data_by_source_code_array = $dataRetrievalDelegate->retrieveDataFromSourceCollection($sourceCollection);
        // TODO Check for correct interface for $articlePersisterDelegate
        $articlePersisterDelegate = $processModelToProcess->getDelegate(self::ARTICLE_PERSISTER_DELEGATE_CODE);
        $articlePersisterResult = $articlePersisterDelegate->persistArticles($processed_article_data_by_source_code_array, $sourceCollection);
        // TODO Check for correct interface for $feedResultsLogger
        $feedResultsLogger = $processModelToProcess->getDelegate(self::PROCESS_LOGGER_DELEGATE_CODE);
        $feedResultsLogger->compileLogFeedResults($articlePersisterResult, $sourceCollection);

        return $feedResultsLogger;
    }
}
