<?php
/**
 * Author: Sean Dunagan
 * Created: 4/10/15
 *
 * class Worldview_Source_Helper_Raw_Data_Processor_Huffington_World
 */

class Worldview_Source_Helper_Raw_Data_Processor_Huffington_World
    extends Worldview_Source_Helper_Raw_Data_Processor_Abstract
    implements Worldview_Source_Helper_Raw_Data_Processor_Interface
{
    const HUFFINGTON_POST_AUTHOR_FEED_FIELD = 'author';

    // TODO Implement this class's functionality
    public function getFieldConversionArray()
    {
        $conversion_array = $this->_base_conversion_array;
        $conversion_array[Worldview_Source_Helper_Data::AUTHOR_WORLDVIEW_APP_FIELD] = self::HUFFINGTON_POST_AUTHOR_FEED_FIELD;

        return $this->_base_conversion_array;
    }

    public function scrapeArticleData(array $raw_article_data)
    {
        return '';
    }
}
