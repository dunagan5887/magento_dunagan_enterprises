<?php

/**
 * Author: Sean Dunagan (github: dunagan5887)
 * Date: 8/9/16
 */
class Worldview_Article_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}