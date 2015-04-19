<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * class Dunagan_Base_Model_Delegator_Abstract
 */

class Dunagan_Base_Model_Delegator_Abstract
    extends Varien_Object
    implements Dunagan_Base_Model_Delegator_Interface
{
    const ERROR_ATTEMPT_TO_GET_UNSET_DELEGATE = 'An attempt was made to access delegate with code %s on object of type %s, but no delegate with that code has been set';

    protected $_delegate_helper_array = array();

    public function getDelegate($delegate_code)
    {
        if (isset($this->_delegate_helper_array[$delegate_code]))
        {
            return $this->_delegate_helper_array[$delegate_code];
        }

        $error_message = sprintf(self::ERROR_ATTEMPT_TO_GET_UNSET_DELEGATE, $delegate_code, __CLASS__);
        Mage::log($error_message);
        $exceptionToThrow = new Dunagan_Base_Model_Exception($error_message);
        Mage::logException($exceptionToThrow);
        throw $exceptionToThrow;
    }

    public function setDelegate($delegate_code, Dunagan_Base_Model_Delegate_Interface $delegateObject)
    {
        // TODO check to ensure that $delegateObject implements Dunagan_Base_Model_Delegate_Interface
        $this->_delegate_helper_array[$delegate_code] = $delegateObject;
        $delegateObject->setDelegator($this);
        return $this;
    }
}
 