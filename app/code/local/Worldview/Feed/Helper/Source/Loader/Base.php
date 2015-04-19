<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * Class Worldview_Feed_Helper_Source_Loader_Base
 */

abstract class Worldview_Feed_Helper_Source_Loader_Base
    extends Dunagan_Base_Model_Delegate_Abstract
    implements Worldview_Feed_Helper_Source_Loader_Interface
{
    abstract public function loadSourceCollection();
}
