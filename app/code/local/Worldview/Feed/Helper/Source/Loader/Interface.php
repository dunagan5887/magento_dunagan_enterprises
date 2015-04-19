<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * interface Worldview_Feed_Helper_Source_Loader_Interface
 */

interface Worldview_Feed_Helper_Source_Loader_Interface
    extends Dunagan_Base_Model_Delegate_Interface
{
    /**
     * @return Worldview_Source_Model_Mysql4_Source_Collection - Collection of sources to retrieve articles from
     */
    public function loadSourceCollection();
}