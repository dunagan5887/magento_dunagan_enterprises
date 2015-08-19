<?php
/**
 * Author: Sean Dunagan
 * Created: 8/19/15
 */

class Test_Magento_Logger
{
    static public function logMessage($message)
    {
        Mage::log($message);
    }

    static public function echoMessage($message)
    {
        echo $message;
    }
}
