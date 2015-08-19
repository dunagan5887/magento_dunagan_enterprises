<?php

interface Dunagan_Process_Model_Locked_Cron_Interface
    extends Dunagan_Process_Model_Locked_Interface
{
    /**
     * Implemented by Dunagan_Process_Model_Locked_Cron_Abstract
     * This is the method which should be called by cron's calling block
     *
     * @return mixed
     */
    public function attemptCronExecution();

    /**
     * The 2 methods below required to be implemented by leaf subclasses of Dunagan_Process_Model_Locked_Cron_Abstract
     *
     * @return mixed
     */
    public function executeCron($locked_thread_number);

    public function getCronCode();

    public function getParallelThreadCount();

    public function attemptLockForThread($thread_number);
}
