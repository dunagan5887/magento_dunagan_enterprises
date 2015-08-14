<?php
/**
 * Author: Sean Dunagan
 * Created: 8/13/15
 */

interface Dunagan_ProcessQueue_Model_Task_Interface
{
    public function getId();

    public function getStatus();

    public function attemptUpdatingRowAsProcessing();

    public function selectForUpdate();

    /**
     * Should return data regarding the execution of the Task. For now, only status is set
     *
     * @return Dunagan_ProcessQueue_Model_Task_Result_Interface
     */
    public function executeTask();

    public function actOnTaskResult(Dunagan_ProcessQueue_Model_Task_Result_Interface $taskExecutionResult);

    public function setTaskAsErrored();
}