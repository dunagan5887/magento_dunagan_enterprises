<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 5:50 PM
 */

$sources_to_add_array = array(
    'cnn_world' => array(
        'active' => 1,
        'name' => 'CNN World News Feed',
        'feed_url' => 'http://rss.cnn.com/rss/cnn_world.rss',
        'category' => 'World',
        'type' => 'RSS',
        'raw_data_processor' => 'worldview_source/raw_data_processor_cnn_world'
    ),
    'fox_news_world' => array(
        'active' => 1,
        'name' => 'Fox News World News Feed',
        'feed_url' => 'http://feeds.foxnews.com/foxnews/world',
        'category' => 'World',
        'type' => 'RSS',
        'raw_data_processor' => 'worldview_source/raw_data_processor_foxnews_world'
    ),
    'msnbc_world' => array(
        'active' => 1,
        'name' => 'MSNBC World News Feed',
        'feed_url' => 'http://feeds.nbcnews.com/feeds/worldnews',
        'category' => 'World',
        'type' => 'RSS',
        'raw_data_processor' => 'worldview_source/raw_data_processor_msnbc_world'
    ),
    'huffington_post_world' => array(
        'active' => 1,
        'name' => 'Huffington Post World News Feed',
        'feed_url' => 'http://www.huffingtonpost.com/feeds/verticals/world/index.xml',
        'category' => 'World',
        'type' => 'RSS',
        'raw_data_processor' => 'worldview_source/raw_data_processor_huffington_world'
    ),
    'usa_today_world' => array(
        'active' => 1,
        'name' => 'USA Today World News Feed',
        'feed_url' => 'http://rssfeeds.usatoday.com/UsatodaycomWorld-TopStories',
        'category' => 'World',
        'type' => 'RSS',
        'raw_data_processor' => 'worldview_source/raw_data_processor_usatoday_world'
    ),
);

foreach ($sources_to_add_array as $source_code => $source_data_array)
{
    $sourceToAdd = Mage::getModel('worldview_source/source')
                    ->setCode($source_code)
                    ->addData($source_data_array);

    $sourceToAdd->save();
}
