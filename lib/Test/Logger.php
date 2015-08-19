<?php
/**
 * Author: Sean Dunagan
 * Created: 8/19/15
 */

class Test_Logger
{
    static public function logMessage($message)
    {
        self::echoMessage($message);
    }

    static public function echoMessage($message)
    {
        echo $message;
    }
}
