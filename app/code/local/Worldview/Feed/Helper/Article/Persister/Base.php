<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 * Class Worldview_Feed_Helper_Article_Persister_Base
 */

class Worldview_Feed_Helper_Article_Persister_Base
    extends Dunagan_Base_Model_Delegate_Abstract
    implements Worldview_Feed_Helper_Article_Persister_Interface
{
    const ERROR_INVALID_SOURCE_CODE_IN_RAW_ARTICLE_DATA_ARRAY = 'Source code %s was passed in as an index of the processed article data array to %s::%s, but there was no corresponding source model in the source collection passed into the method.';
    const EXCEPTION_TRYING_TO_PERSIST_ARTICLE = 'An exception occurred while object of class %s was trying to persist an article from source %s with link %s to the database: %s';

    protected $_article_links_array = array();
    protected $_array_of_already_persisted_links = array();

    protected $_coreDateModel = null;

    public function persistArticles(array $processed_article_data_by_source_code_array,
                                    Worldview_Source_Model_Mysql4_Source_Collection $sourceCollection)
    {
        $source_model_by_code_array = $this->_getSourceByCodeArray($sourceCollection);
        $articlePersisterResultModel = Mage::helper($this->_getArticlePersisterResultHelperClassname());

        /*
         * We need to ensure that we don't load any articles which have already been loaded into the database
         * Generate an array of all article link urls in $processed_article_data_array so that we only have to make one
         * database query in order to check against all articles in $processed_article_data_array
         */
        $this->_initializeArrayOfProcessedArticleLinks($processed_article_data_by_source_code_array);
        $this->_initializeAlreadyPersistedLinksArray();

        foreach ($processed_article_data_by_source_code_array as $source_code => $processed_article_data_from_source)
        {
            $sourceModel = isset($source_model_by_code_array[$source_code]) ? $source_model_by_code_array[$source_code] : null;
            if ((!is_object($sourceModel)) || (!$sourceModel->getId()))
            {
                // TODO TEST THIS
                $error_message = sprintf(self::ERROR_INVALID_SOURCE_CODE_IN_RAW_ARTICLE_DATA_ARRAY, $source_code, __CLASS__, __METHOD__);
                Mage::log($error_message);
                $exceptionToLog = new Exception($error_message);
                Mage::logException($exceptionToLog);
                // We need to be able to record a source id on each article object
                continue;
            }

            foreach ($processed_article_data_from_source as $processed_article_data_array)
            {
                $this->_attemptArticlePersistence($processed_article_data_array, $sourceModel, $articlePersisterResultModel);
            }
        }

        return $articlePersisterResultModel;
    }

    protected function _attemptArticlePersistence($processed_articles_data_array, $sourceModel, $articlePersisterResultModel)
    {
        // Check if this article's link has already been persisted
        $article_link = isset($processed_articles_data_array[Worldview_Source_Helper_Data::LINK_WORLDVIEW_APP_FIELD])
                            ? $processed_articles_data_array[Worldview_Source_Helper_Data::LINK_WORLDVIEW_APP_FIELD] : null;

        if (empty($article_link))
        {   // TODO TEST THIS
            // Don't persist an article without a link
            $articlePersisterResultModel->addArticleMissingLink($sourceModel, $processed_articles_data_array);
            return;
        }

        if (in_array($article_link, $this->_array_of_already_persisted_links))
        {
            // Don't persist an article which is already in the database
            $articlePersisterResultModel->addArticleAlreadyPersisted($sourceModel, $processed_articles_data_array);
            return;
        }

        try
        {
            $articleModelToPersist = Mage::getModel($this->_getArticleClassname());

            // Set all data in the array. Whatever fields were defined in the array will be persisted to the database
            $articleModelToPersist->setData($processed_articles_data_array);
            $articleModelToPersist->setFeedSourceId($sourceModel->getId());
            // TODO Ideally created_at field is set by the resource model
            $articleModelToPersist->setCreatedAt($this->_getCoreDateModel()->gmtDate());
            $articleModelToPersist->save();
        }
        catch(Exception $e)
        {
            // TODO TEST THIS
            $error_message = sprintf(self::EXCEPTION_TRYING_TO_PERSIST_ARTICLE, __CLASS__, $sourceModel->getCode(), $article_link, $e->getMessage());
            Mage::log($error_message);
            $exceptionToLog = new Exception($error_message);
            Mage::logException($exceptionToLog);

            $articlePersisterResultModel->addArticlePersistException($e->getMessage(), $sourceModel, $article_link);
            return;
        }

        $articlePersisterResultModel->addArticlePersistSuccess($articleModelToPersist, $sourceModel);
    }

    protected function _initializeAlreadyPersistedLinksArray()
    {
        // TODO update this query to only grab the link fields of the selected rows
        $articlesAlreadyPersistedCollection = Mage::getModel('worldview_article/article')
                                        ->getCollection()
                                        ->addFieldToFilter('link', array('in' => $this->_article_links_array));

        $this->_array_of_already_persisted_links = array();

        foreach ($articlesAlreadyPersistedCollection->getItems() as $persistedArticle)
        {
            $this->_array_of_already_persisted_links[] = $persistedArticle->getLink();
        }

        return $this->_array_of_already_persisted_links;
    }

    protected function _initializeArrayOfProcessedArticleLinks(array $processed_article_data_by_source_code_array)
    {
        foreach ($processed_article_data_by_source_code_array as $processed_articles_data_from_source)
        {
            foreach ($processed_articles_data_from_source as $processed_article_data)
            {
                $article_link = isset($processed_article_data[Worldview_Source_Helper_Data::LINK_WORLDVIEW_APP_FIELD])
                                    ? $processed_article_data[Worldview_Source_Helper_Data::LINK_WORLDVIEW_APP_FIELD] : '';

                if(!empty($article_link))
                {
                    $this->_article_links_array[] = $article_link;
                }
            }
        }

        $this->_article_links_array = array_unique($this->_article_links_array);
        return $this->_article_links_array;
    }

    protected function _getSourceByCodeArray(Worldview_Source_Model_Mysql4_Source_Collection $sourceCollection)
    {
        $source_model_by_code_array = array();

        foreach ($sourceCollection as $source)
        {
            $source_model_by_code_array[$source->getCode()] = $source;
        }

        return $source_model_by_code_array;
    }

    // TODO ensure that subclass hasn't declared an invalid classname here
    protected function _getArticlePersisterResultHelperClassname()
    {
        return 'worldview_feed/article_persister_result';
    }

    // TODO ensure that subclass hasn't declared an invalid classname here
    protected function _getArticleClassname()
    {
        return 'worldview_article/article';
    }

    protected function _getCoreDateModel()
    {
        if (is_null($this->_coreDateModel))
        {
            $this->_coreDateModel = Mage::getModel('core/date');
        }

        return $this->_coreDateModel;
    }
}
