<?php
/**
 * Author: Sean Dunagan
 * Created: 4/7/15
 *
 * class Worldview_Source_Block_Adminhtml_Source_Form_Container
 */

class Worldview_Article_Block_Adminhtml_Article_Edit
    extends Dunagan_Base_Block_Adminhtml_Widget_Form_Container
{
    // TODO Implement ACL for deleting sources
    public function __construct()
    {
        parent::__construct();

        $this->_removeButton('delete');
    }
}
