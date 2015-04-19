<?php
/**
 * Author: Sean Dunagan
 * Created: 4/10/15
 *
 * class Worldview_Source_Helper_Raw_Data_Processor_Foxnews_World
 */

class Worldview_Source_Helper_Raw_Data_Processor_Foxnews_World
    extends Worldview_Source_Helper_Raw_Data_Processor_Abstract
    implements Worldview_Source_Helper_Raw_Data_Processor_Interface
{
    // TODO Implement this class's functionality
    public function getFieldConversionArray()
    {
        return $this->_base_conversion_array;
    }

    public function scrapeArticleData(array $raw_article_data)
    {
        return '';
    }
}
