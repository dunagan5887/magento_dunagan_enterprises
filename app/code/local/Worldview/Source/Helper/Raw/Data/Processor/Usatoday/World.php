<?php
/**
 * Author: Sean Dunagan
 * Created: 4/10/15
 *
 * class Worldview_Source_Helper_Raw_Data_Processor_Usatoday_World
 */

class Worldview_Source_Helper_Raw_Data_Processor_Usatoday_World
    extends Worldview_Source_Helper_Raw_Data_Processor_Abstract
    implements Worldview_Source_Helper_Raw_Data_Processor_Interface
{
    const USATODAY_LINK_FEED_FIELD = 'link';

    // TODO Implement this class's functionality
    public function getFieldConversionArray()
    {
        $conversion_array = $this->_base_conversion_array;
        $conversion_array[Worldview_Source_Helper_Data::LINK_WORLDVIEW_APP_FIELD] = self::USATODAY_LINK_FEED_FIELD;
        return $conversion_array;
    }

    public function scrapeArticleData(array $raw_article_data)
    {
        return '';
    }
}
