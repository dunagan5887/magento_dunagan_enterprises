<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * class Dunagan_Base_Model_Delegate_Abstract
 */

class Dunagan_Base_Model_Delegate_Abstract
    extends Varien_Object
    implements Dunagan_Base_Model_Delegate_Interface
{
    const ERROR_DELEGATOR_OBJECT_NOT_SET = 'Attempt was made to access the delegator object for delegate object of class %s, but no deleator object has been set.';

    protected $_delegatorObject = null;

    public function getDelegator()
    {
        if (!is_object($this->_delegatorObject))
        {
            $error_message = sprintf(self::ERROR_DELEGATOR_OBJECT_NOT_SET, __CLASS__);
            Mage::log($error_message);
            $exceptionToThrow = new Dunagan_Base_Model_Exception($error_message);
            Mage::logException($exceptionToThrow);
            throw $exceptionToThrow;
        }
        return $this->_delegatorObject;
    }
    
    public function setDelegator(Dunagan_Base_Model_Delegator_Interface $delegatorObject)
    {
        $this->_delegatorObject = $delegatorObject;
    }
}
 