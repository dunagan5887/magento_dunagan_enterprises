<?php
/**
 * Author: Sean Dunagan
 * Created: 8/18/15
 */

class Test_Memory extends Test_Logger
{
    const MEMORY_USED_TEMPLATE = "Memory Used from %s to %s: %s";
    const AVERAGE_LAPSE_BY_CODE_TEMPLATE = "Average Memory lapse for code %s: %s";
    const MEMORY_NOT_RECORDED_BY_CODE_TEMPLATE = "No Memory lapse records were taken for code %s";

    static protected $_memory_lapse_sum_by_code = array();
    static protected $_memory_lapse_counter_by_code = array();

    static protected $_memory_usage_at_step = array();

    static public function registerLapseSumCode($code)
    {
        self::$_memory_lapse_sum_by_code[$code] = 0;
        self::$_memory_lapse_counter_by_code[$code] = 0;
    }

    static public function recordMemoryLapseBetweenStepsByCode($from_step, $to_step, $code)
    {
        $lapse = self::getLapseBetweenSteps($from_step, $to_step);

        self::$_memory_lapse_sum_by_code[$code] = self::$_memory_lapse_sum_by_code[$code] + $lapse;
        self::$_memory_lapse_counter_by_code[$code] = self::$_memory_lapse_counter_by_code[$code] + 1;
    }

    static public function logAverageLapseByCode($code)
    {
        $lapse_counter = self::$_memory_lapse_counter_by_code[$code];
        if (empty($lapse_counter))
        {
            // Avoid division by zero
            $log_message = sprintf(self::MEMORY_NOT_RECORDED_BY_CODE_TEMPLATE, $code);
            self::logMessage($log_message);
            return;
        }

        $lapse_sum = doubleval(self::$_memory_lapse_sum_by_code[$code]);
        $lapse_average_by_code = $lapse_sum / $lapse_counter;

        $log_message = sprintf(self::AVERAGE_LAPSE_BY_CODE_TEMPLATE, $code, round($lapse_average_by_code, 4));
        self::logMessage($log_message);
    }

    static public function recordCurrentMemoryUsageAtStep($step)
    {
        self::$_memory_usage_at_step[$step] = memory_get_usage();
    }

    static public function logMemoryLapseBetweenSteps($from_step, $to_step)
    {
        $lapse = self::getLapseBetweenSteps($from_step, $to_step);

        $log_message = sprintf(self::MEMORY_USED_TEMPLATE, $from_step, $to_step, $lapse);
        self::logMessage($log_message);
    }

    static public function getLapseBetweenSteps($from_step, $to_step)
    {
        $from_memory = self::$_memory_usage_at_step[$from_step];
        $to_memory = self::$_memory_usage_at_step[$to_step];

        $lapse = $to_memory - $from_memory;
        return $lapse;
    }

    static public function logMaxMemoryUsage()
    {
        $max_usage = memory_get_peak_usage();
        $message = "Max memory used: " . $max_usage;
        self::logMessage($message);
    }
}
