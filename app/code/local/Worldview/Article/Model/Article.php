<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 7:37 PM
 *
 * class Worldview_Article_Model_Article
 */
class Worldview_Article_Model_Article extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('worldview_article/article');
    }

    /**
     * TODO Ideally what would happen here is that the Worldview_Article_Model_Mysql4_Article Resource
     * Singleton would load all valid source id's in the database, and this method would check to ensure that the
     * $feed_source_id parameter passed in is one of the fetched source ids. If not, throw an error
     *
     * @param int $feed_source_id - Should reference the entity_id value of a Worldview_Source_Model_Source object in the
     *                                  database
     * @return self - Default Varien_Object functionality here is to return this object
     *
        public function setFeedSourceId($feed_source_id)
        {
            return parent::setFeedSourceId($feed_source_id);
        }
     */
}
