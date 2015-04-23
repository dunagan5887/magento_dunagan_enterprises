<?php
/**
 * Author: Sean Dunagan
 * Created: 4/23/15
 */

class Dunagan_CustomLayout_Block_Adminhtml_Page_Menu
    extends Mage_Adminhtml_Block_Page_Menu
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('dunagan/page/menu.phtml');
    }
}
