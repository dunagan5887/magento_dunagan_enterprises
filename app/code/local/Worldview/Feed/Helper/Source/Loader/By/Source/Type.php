<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 * class Worldview_Feed_Helper_Source_Loader_By_Source_Type
 */


class Worldview_Feed_Helper_Source_Loader_By_Source_Type
    extends Worldview_Feed_Helper_Source_Loader_Base
    implements Worldview_Feed_Helper_Source_Loader_Interface
{
    public function loadSourceCollection()
    {
        $processModel = $this->getDelegator();
        // For Process Worldview_Feed_Model_Process_Article_Retrieval, the code refers to the feed source type
        $source_feed_type = $processModel->getCode();
        $sourceCollection = Mage::getModel('worldview_source/source')
                                ->getCollection()
                                ->addFieldToFilter('active', 1)
                                ->addFieldToFilter('type', $source_feed_type);

        return $sourceCollection;
    }
}
