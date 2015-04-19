<?php
/**
 * Author: Sean Dunagan
 * Created: 4/10/15
 *
 * class Worldview_Feed_Helper_Article_Persister_Result
 */

class Worldview_Feed_Helper_Article_Persister_Result
{
    protected $_articles_missing_link = array();
    protected $_articles_already_persisted = array();
    protected $_article_persist_exception = array();
    protected $_articles_persisted_success = array();

    public function getArticlesMissingLinkArray()
    {
        return $this->_articles_missing_link;
    }

    public function addArticleMissingLink(Worldview_Source_Model_Source $sourceModel, array $processed_articles_data_array)
    {
        // TODO Be more specific with this error message potentially regarding which article did not contain a link
        $this->_addIndexToArrayKey($this->_articles_missing_link, $sourceModel->getCode(), $processed_articles_data_array);
    }

    public function getArticlesAlreadyPersisted()
    {
        return $this->_articles_already_persisted;
    }

    public function addArticleAlreadyPersisted(Worldview_Source_Model_Source $sourceModel, array $processed_articles_data_array)
    {
        $this->_addIndexToArrayKey($this->_articles_already_persisted, $sourceModel->getCode(), $processed_articles_data_array);
    }

    public function getArticlesPersistException()
    {
        return $this->_article_persist_exception;
    }

    public function addArticlePersistException($exception_message, $sourceModel, $article_link)
    {
        $data_array = array('exception_message' => $exception_message, 'article_link' => $article_link);
        $this->_addIndexToArrayKey($this->_article_persist_exception, $sourceModel->getCode(), $data_array);
    }

    public function getArticlesPersistedSuccessfully()
    {
        return $this->_articles_persisted_success;
    }

    public function addArticlePersistSuccess($articleModelToPersist, $sourceModel)
    {
        $this->_addIndexToArrayKey($this->_articles_persisted_success, $sourceModel->getCode(), $articleModelToPersist);
    }

    /**
     * @param array $array_to_add_to - This array is likely to be holding objects as its values, so we need to
     *                                  pass the arrays in by reference so that we aren't copying all of the data in the array
     * @param $key_to_set_on
     * @param $value_to_set
     */
    protected function _addIndexToArrayKey(array &$array_to_add_to, $key_to_set_on, $value_to_set)
    {
        if (!isset($array_to_add_to[$key_to_set_on]))
        {
            $array_to_add_to[$key_to_set_on] = array();
        }

        $array_to_add_to[$key_to_set_on][] = $value_to_set;
    }
}
