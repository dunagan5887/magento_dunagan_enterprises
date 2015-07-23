<?php
/**
 * Author: Sean Dunagan
 * Created: 7/23/15
 */

class Dunagan_Base_Controller_Varien_Exception extends Mage_Core_Controller_Varien_Exception
{
    public function prepareRedirect($path, $arguments = array())
    {
        $this->_resultCallback = self::RESULT_REDIRECT;
        $this->_resultCallbackParams = array($path, $arguments);
        return $this;
    }
}
