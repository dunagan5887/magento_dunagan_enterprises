<?php
/**
 * Author: Sean Dunagan
 * Created: 4/10/15
 *
 * class Worldview_Source_Helper_Raw_Data_Processor_Default
 */

class Worldview_Source_Helper_Raw_Data_Processor_Default
    extends Worldview_Source_Helper_Raw_Data_Processor_Abstract
    implements Worldview_Source_Helper_Raw_Data_Processor_Interface
{
    // This class should only be used in the event that a source's raw data processor is misconfigured in the database
    public function getFieldConversionArray()
    {
        return array('title' => 'title');
    }

    public function scrapeArticleData(array $raw_article_data)
    {
        return '';
    }
}
