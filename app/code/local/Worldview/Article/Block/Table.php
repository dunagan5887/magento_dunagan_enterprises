<?php
/**
 * Author: Sean Dunagan (github: dunagan5887)
 * Date: 8/9/16
 */
class Worldview_Article_Block_Table extends Mage_Core_Block_Template
{
    /**
     * This method needs to query the database `worldview_article_entity` table to fetch all of the articles in the
     *  database which should be displayed.
     *
     * For now, let's restrict this collection to only query a maximum of 50 articles. We'll put in some more
     *  sophisticated logic later for which articles to query
     *
     * Ideally, this query would execute a join on the `worldview_source_entity` table so that we can display the
     *  source that each article came from, but we can move on to that later
     *
     * @return Worldview_Article_Model_Mysql4_Article_Collection
     */
    public function getArticleCollectionToDisplay()
    {

    }
}
