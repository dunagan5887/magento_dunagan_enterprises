<?php
/**
 * Author: Sean Dunagan
 * Created: 8/13/15
 * Class Dunagan_ProcessQueue_Model_Cron
 */

class Dunagan_ProcessQueue_Model_Cron
{
    const CRON_UNCAUGHT_EXCEPTION = 'An uncaught exception occurred while processing the Dunagan Process Queue: %s';

    public function processQueueTasks()
    {
        try
        {
            Mage::helper('dunagan_process_queue/task_processor')->processQueueTasks();
            Mage::helper('dunagan_process_queue/task_processor_unique')->processQueueTasks();
        }
        catch(Exception $e)
        {
            $error_message = sprintf(self::CRON_UNCAUGHT_EXCEPTION, $e->getMessage());
            Mage::log($error_message, null, 'dunagan_process_queue_error.log');
            $exceptionToLog = new Exception($error_message);
            Mage::logException($exceptionToLog);
        }
    }
}
