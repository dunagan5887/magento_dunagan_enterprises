<?php
/**
 * Author: Sean Dunagan
 * Created: 8/14/15
 */

interface Dunagan_ProcessQueue_Model_Task_Result_Interface
{
    /**
     * Flag denoting whether database transactions related to the task should be rolled back
     *
     * @return boolean
     */
    public function shouldTransactionBeRolledBack();

    /**
     * Returns the status of a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     * @return mixed - Expected to return one of the STATUS_* constants in class Dunagan_ProcessQueue_Model_Task
     */
    public function getTaskStatus();

    /**
     * Sets the status of a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     *  @return $this
     */
    public function setTaskStatus($status);

    /**
     * Returns any messaging resulting from a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     * @return mixed - string|null
     */
    public function getTaskStatusMessage();

    /**
     * Sets any messaging resulting from a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     * @return $this
     */
    public function setTaskStatusMessage($status);

    /**
     * To be used when an execution of a callback in Dunagan_ProcessQueue_Model_Task::executeTask() does not return
     *      an object of type Dunagan_ProcessQueue_Model_Task_Result
     */
    public function getMethodCallbackResult();

    /**
     * To be used when an execution of a callback in Dunagan_ProcessQueue_Model_Task::executeTask() does not return
     *      an object of type Dunagan_ProcessQueue_Model_Task_Result
     */
    public function setMethodCallbackResult($methodCallbackResult);

    // TODO Implement recording of task execution status
}