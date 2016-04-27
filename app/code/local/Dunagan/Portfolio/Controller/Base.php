<?php
/**
 * Author: Sean Dunagan (https://github.com/dunagan5887)
 * Created: 4/26/16
 */

class Dunagan_Portfolio_Controller_Base extends Mage_Core_Controller_Front_Action
{
    protected function _initLayout()
    {
        $this->loadLayout(array('default', 'dunagan_portfolio'));
    }
}
