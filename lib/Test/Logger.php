<?php
/**
 * Author: Sean Dunagan
 * Created: 8/19/15
 */

class Test_Logger
{
    static protected $_log_file = 'thread_0';

    static public function setThreadNumber($thread_number = 0)
    {
        self::$_log_file = 'thread_' . $thread_number;
    }

    static public function logMessage($message)
    {
        self::echoMessage($message);
    }

    static public function echoMessage($message)
    {
        echo $message;
    }
}
