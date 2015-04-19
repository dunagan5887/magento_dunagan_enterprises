<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 8:53 PM
 */
class Worldview_Source_Model_Mysql4_Source_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('worldview_source/source');
    }
}
