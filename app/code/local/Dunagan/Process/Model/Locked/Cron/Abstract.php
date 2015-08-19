<?php

abstract class Dunagan_Process_Model_Locked_Cron_Abstract
    extends Dunagan_Process_Model_Locked_Abstract
    implements Dunagan_Process_Model_Locked_Cron_Interface
{
    const ERROR_UNABLE_TO_SECURE_LOCK_FILE = 'Unable to secure a Lock for cron process %s. The cron will not run.';
    const ERROR_EXECUTING_CRON = 'An uncaught exception occurred while executing cron process %s: %s';
    const ERROR_RELEASING_LOCK = 'An uncaught exception occurred while attempting to release the Lock from cron process %s: %s';

    abstract public function executeCron($locked_thread_number);

    abstract public function getCronCode();

    abstract public function getParallelThreadCount();

    abstract public function attemptLockForThread($thread_number);

    public function attemptCronExecution()
    {
        $locked_thread_number = $this->attemptLock();

        if (false !== $locked_thread_number)
        {
            try
            {
                $this->executeCron($locked_thread_number);
            }
            catch(Exception $e)
            {
                $error_message = sprintf(self::ERROR_EXECUTING_CRON, $this->getCronCode(), $e->getMessage());
                $this->_logError($error_message);
            }

            try
            {
                $this->releaseLock();
            }
            catch(Exception $e)
            {
                $error_message = sprintf(self::ERROR_RELEASING_LOCK, $this->getCronCode(), $e->getMessage());
                $this->_logError($error_message);
            }
        }
        else
        {
            $cron_code = $this->getCronCode();
            $error_message = sprintf(self::ERROR_UNABLE_TO_SECURE_LOCK_FILE, $cron_code);

            $this->_logError($error_message);
        }
    }

    public function attemptLock()
    {
        $thread_count = $this->getParallelThreadCount();

        for($thread_number = 1; $thread_number <= $thread_count; $thread_number++)
        {
            $lock_successful = $this->attemptLockForThread($thread_number);
            if ($lock_successful)
            {
                return $thread_number;
            }
        }

        return false;
    }
}
