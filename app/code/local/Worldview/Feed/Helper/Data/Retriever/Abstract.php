<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * Class Worldview_Feed_Helper_Data_Retriever_Abstract
 */

abstract class Worldview_Feed_Helper_Data_Retriever_Abstract
    extends Dunagan_Base_Model_Delegate_Abstract
    implements Worldview_Feed_Helper_Data_Retriever_Interface
{
    abstract public function retrieveDataFromSourceCollection(Worldview_Source_Model_Mysql4_Source_Collection $sourceCollection);
}
