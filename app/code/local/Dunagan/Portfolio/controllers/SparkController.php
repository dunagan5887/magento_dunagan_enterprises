<?php
/**
 * Author: Sean Dunagan (https://github.com/dunagan5887)
 * Created: 4/29/16
 */

class Dunagan_Portfolio_SparkController extends Dunagan_Portfolio_Controller_Base
{
    public function indexAction()
    {
        $this->_initLayout();

        $this->renderLayout();
    }
}
