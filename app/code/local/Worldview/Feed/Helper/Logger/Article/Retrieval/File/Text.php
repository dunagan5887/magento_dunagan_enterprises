<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * Class Worldview_Feed_Helper_Logger_Retrieval_File_Text
 */

class Worldview_Feed_Helper_Logger_Article_Retrieval_File_Text
    extends Worldview_Feed_Helper_Logger_Article_Retrieval_Abstract
    implements Worldview_Feed_Helper_Logger_Article_Retrieval_Interface
{
    const SUCCESS_ARTICLE_PERSISTED_MESSAGE = "%s\n%s - %s";

    public function getArticlePersistSuccessMessage($source_code, $persistedArticle)
    {
        $article_title = $persistedArticle->getTitle();
        $article_link = $persistedArticle->getLink();
        $publication_date = $persistedArticle->getPublicationDate();
        $article_success_message = sprintf(self::SUCCESS_ARTICLE_PERSISTED_MESSAGE, $article_link, $publication_date, $article_title);
        return $article_success_message;
    }

    public function flushLogs()
    {
        return;
    }
}
