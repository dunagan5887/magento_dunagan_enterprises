<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 7:37 PM
 */
class Worldview_Article_Model_Mysql4_Article_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('worldview_article/article');
    }
}
