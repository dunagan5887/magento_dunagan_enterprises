<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 6:13 PM
 */
class Worldview_Source_Helper_Data extends Mage_Core_Helper_Data
{
    // TODO Should probably move these values into config.xml
    const SCRAPED_ARTICLE_TEXT_FEED_FIELD = 'scraped_article_text';
    const TITLE_FEED_FIELD = 'title';
    const LINK_FEED_FIELD = 'guid';
    const DESCRIPTION_FEED_FIELD = 'description';
    const PUBLICATION_DATE_FEED_FIELD = 'pubDate';

    const ARTICLE_TEXT_WORLDVIEW_APP_FIELD = 'article_text';
    const TITLE_WORLDVIEW_APP_FIELD = 'title';
    const LINK_WORLDVIEW_APP_FIELD = 'link';
    const DESCRIPTION_WORLDVIEW_APP_FIELD = 'description';
    const PUBLICATION_DATE_WORLDVIEW_APP_FIELD = 'publication_date';
    const AUTHOR_WORLDVIEW_APP_FIELD = 'author';
    // TODO Should probably move the above values into config.xml
}
