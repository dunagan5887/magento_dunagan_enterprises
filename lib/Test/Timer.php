<?php
/**
 * Author: Sean Dunagan
 * Created: 8/18/15
 */

class Test_Timer extends Test_Logger
{
    static protected $_time_sum_by_code = array();
    static protected $_counter_by_code = array();

    static public function declareTimer($code)
    {
        self::$_time_sum_by_code[$code] = 0.0;
        self::$_counter_by_code[$code] = 0;
    }

    static public function addTimeByCode($code, $time)
    {
        self::$_time_sum_by_code[$code] = self::$_time_sum_by_code[$code] + $time;
        self::$_counter_by_code[$code] = self::$_counter_by_code[$code] + 1;
    }

    static public function logAverageTimesByCode($code)
    {
        $time_sum = self::$_time_sum_by_code[$code];
        $counter = self::$_counter_by_code[$code];
        $average = $time_sum / doubleval($counter);
        $log_message = $code . " average: " . $average;
        self::logMessage($log_message);
    }

    static public function echoAverageTimesByCode($code)
    {
        $time_sum = self::$_time_sum_by_code[$code];
        $counter = self::$_counter_by_code[$code];
        $average = $time_sum / doubleval($counter);
        $log_message = $code . " average: " . $average . "\n";
        self::echoMessage($log_message);
    }
}
