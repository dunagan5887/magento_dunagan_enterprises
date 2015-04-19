<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * interface Dunagan_Base_Model_Delegator_Interface
 */

interface Dunagan_Base_Model_Delegator_Interface
{
    public function setDelegate($delegate_code, Dunagan_Base_Model_Delegate_Interface $delegateObject);

    public function getDelegate($delegate_code);
}
