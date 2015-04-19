<?php
/**
 * Author: Sean Dunagan
 * Created: 4/11/15
 *
 * class Worldview_Feed_Helper_Logger_Article_Retrieval_Abstract
 */

abstract class Worldview_Feed_Helper_Logger_Article_Retrieval_Abstract
    extends Dunagan_Base_Helper_Processor_Logger_Abstract
    implements Worldview_Feed_Helper_Logger_Article_Retrieval_Interface
{
    // The following will be used by subclasses
    const NOTICE_NO_ARTICLES_PERSISTED_FROM_SOURCE = 'No new articles were found in the feed from source %s';
    const SUCCESS_NUMBER_OF_PERSISTED_ARTICLES = '%s new articles were retrieved from feed %s';
    const NOTICE_ARTICLES_ALREADY_PERSISTED = '%s articles from feed %s were already in the database';
    const ERROR_ARTICLES_MISSING_LINK = '%s articles from feed %s did not contain a link to their webpage. These articles were not saved in the database.';
    const ERROR_ARTICLES_WITH_EXCEPTION = '%s articles from feed %s were unable to be saved to the database due to the following exceptions: %s';
    const ERROR_ARTICLE_LINK_AND_EXCEPTION = 'Articles with link %s had the following exception: %s';

    protected $_errors_by_source_feed = array();
    protected $_source_model_by_code_array = array();

    public function compileLogFeedResults(Worldview_Feed_Helper_Article_Persister_Result $feedArticlePersisterResults,
                                          Worldview_Source_Model_Mysql4_Source_Collection $sourceCollection)
    {
        // Initialize the string which will hold the logs in the event that we're building a string to return
        $this->_initializeCurrentLogString();
        $this->_initializeSourceModelByCodeArray($sourceCollection);

        $data_to_logging_method_array = array(
            array('data_array' => $feedArticlePersisterResults->getArticlesPersistedSuccessfully(),
                    'method' => 'logSuccessfullyPersistedArticles'),
            array('data_array' => $feedArticlePersisterResults->getArticlesAlreadyPersisted(),
                'method' => 'logArticlesAlreadyPersisted'),
            array('data_array' => $feedArticlePersisterResults->getArticlesMissingLinkArray(),
                'method' => 'logArticlesMissingLink')
        );

        foreach ($sourceCollection as $sourceModel)
        {
            $source_code = $sourceModel->getCode();

            foreach ($data_to_logging_method_array as $data_and_method_array)
            {
                $data_array = $data_and_method_array['data_array'];
                $method = $data_and_method_array['method'];

                $source_article_data_to_log = isset($data_array[$source_code]) ? $data_array[$source_code] : null;

                if (is_array($source_article_data_to_log))
                {
                    $this->$method($source_code, $source_article_data_to_log);
                }
            }

            $article_persistence_exceptions_array = $feedArticlePersisterResults->getArticlesPersistException();
            $this->logArticlesPersistingException($source_code, $article_persistence_exceptions_array);
        }
    }

    public function logArticlesPersistingException($source_code, $array_with_persisting_exception)
    {
        if (!empty($array_with_persisting_exception))
        {
            $number_of_articles_with_exception = count($array_with_persisting_exception);
            $source_name = $this->getSourceModelNameByCode($source_code);

            $article_link_and_exception_message_array = array();
            foreach ($array_with_persisting_exception as $article_link_and_exception_message)
            {
                $exception_message = $article_link_and_exception_message['exception_message'];
                $article_link = $article_link_and_exception_message['article_link'];
                $error_message = sprintf(self::ERROR_ARTICLE_LINK_AND_EXCEPTION, $article_link, $exception_message);
                $article_link_and_exception_message_array[] = $error_message;
            }

            $exception_data_to_log = $this->getArticlesWithExceptionsMessage($article_link_and_exception_message_array, $source_name, $number_of_articles_with_exception);
            if (!empty($exception_data_to_log))
            {
                $decorated_exception_message = $this->decorateErrorMessage($exception_data_to_log);
                $this->_addDataToCurrentLogString($decorated_exception_message);
            }
        }

        // Log any errors that were registered with this model
        if(isset($this->_errors_by_source_feed[$source_code])
            && is_array($this->_errors_by_source_feed[$source_code])
        )
        {
            foreach ($this->_errors_by_source_feed[$source_code] as $exception_message)
            {
                $decorated_exception_message = $this->decorateErrorMessage($exception_message);
                $this->_addDataToCurrentLogString($decorated_exception_message);
            }
        }
    }

    public function logArticlesMissingLink($source_code, $array_of_articles_missing_link)
    {
        // TODO Test THIS
        $number_of_articles_missing_link = count($array_of_articles_missing_link);
        $source_name = $this->getSourceModelNameByCode($source_code);
        $error_message = sprintf(self::ERROR_ARTICLES_MISSING_LINK, $number_of_articles_missing_link, $source_name);
        $decorated_error_message = $this->decorateErrorMessage($error_message);
        $this->_addDataToCurrentLogString($decorated_error_message);
    }

    public function logArticlesAlreadyPersisted($source_code, $array_of_articles_already_persisted)
    {
        $number_of_articles_already_persisted = count($array_of_articles_already_persisted);
        $source_name = $this->getSourceModelNameByCode($source_code);
        $notice_message = sprintf(self::NOTICE_ARTICLES_ALREADY_PERSISTED, $number_of_articles_already_persisted, $source_name);
        $decorated_notice_message = $this->decorateNoticeMessage($notice_message);
        $this->_addDataToCurrentLogString($decorated_notice_message);
    }

    public function logSuccessfullyPersistedArticles($source_code, $array_of_persisted_articles_from_source)
    {
        $source_name = $this->getSourceModelNameByCode($source_code);
        if (empty($array_of_persisted_articles_from_source))
        {
            $notice_message = sprintf(self::NOTICE_NO_ARTICLES_PERSISTED_FROM_SOURCE, $source_name);
            $decorated_notice_message = $this->decorateNoticeMessage($notice_message);
            $this->_addDataToCurrentLogString($decorated_notice_message);
            return;
        }

        $number_of_persisted_articles = count($array_of_persisted_articles_from_source);
        $success_message = sprintf(self::SUCCESS_NUMBER_OF_PERSISTED_ARTICLES, $number_of_persisted_articles, $source_name);
        $this->_addDataToCurrentLogString($success_message);

        foreach ($array_of_persisted_articles_from_source as $persistedArticle)
        {
            // For some subclasses of log, we'll want to log more of the article data which was returned that others
            $article_persisted_success_message = $this->getArticlePersistSuccessMessage($source_code, $persistedArticle);
            if (!empty($decorated_success_message))
            {
                $decorated_success_message = $this->decorateSuccessMessage($article_persisted_success_message);
                $this->_addDataToCurrentLogString($decorated_success_message);
            }
        }
    }

    public function logErrorRegardingSourceFeed($source_code, $error_message)
    {
        if (!isset($this->_errors_by_source_feed[$source_code]))
        {
            $this->_errors_by_source_feed[$source_code] = array();
        }

        $this->_errors_by_source_feed[$source_code][] = $error_message;
    }

    public function flushLogsBySourceFeedArray()
    {
        $this->_errors_by_source_feed = array();
    }

    protected function _initializeSourceModelByCodeArray(Worldview_Source_Model_Mysql4_Source_Collection $sourceCollection)
    {
        foreach ($sourceCollection->getItems() as $sourceModel)
        {
            $this->_source_model_by_code_array[$sourceModel->getCode()] = $sourceModel;
        }

        return $this->_source_model_by_code_array;
    }

    public function getSourceModelNameByCode($source_code)
    {
        if (!isset($this->_source_model_by_code_array[$source_code]))
        {
            return $source_code;
        }

        $sourceModel = $this->_source_model_by_code_array[$source_code];
        return $sourceModel->getName();
    }

    // OPTIONAL

    // The following methods are optional for subclass to implement/override

    public function getArticlePersistSuccessMessage($source_code, $persistedArticle)
    {
        return '';
    }

    public function getArticlesWithExceptionsMessage($article_link_and_exception_message_array, $source_name, $number_of_articles_with_exception)
    {
        $imploded_article_exception_string = implode($this->getLineSeparator(), $article_link_and_exception_message_array);
        $overall_articles_with_exception_message = sprintf(self::ERROR_ARTICLES_WITH_EXCEPTION, $number_of_articles_with_exception, $source_name, $imploded_article_exception_string);
        return $overall_articles_with_exception_message;
    }
}
