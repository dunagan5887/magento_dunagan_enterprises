<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * interface Dunagan_Base_Model_Delegator_Interface
 */

interface Dunagan_Base_Model_Delegate_Interface
{
    public function getDelegator();

    public function setDelegator(Dunagan_Base_Model_Delegator_Interface $delegatorObject);
}
