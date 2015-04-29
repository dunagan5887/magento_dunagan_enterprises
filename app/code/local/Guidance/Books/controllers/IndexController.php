<?php
/**
 * Author: Sean Dunagan
 * Created: 4/28/15
 */

class Guidance_Books_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
