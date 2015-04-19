<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 8:19 PM
 */
class Worldview_Feed_Model_Cron
{
    public function cronRetrieveArticlesFromFeed()
    {
        $helper = Mage::helper('worldview_feed/article_retrieval_processor');
        $helper->executeProcesses();
    }
}
