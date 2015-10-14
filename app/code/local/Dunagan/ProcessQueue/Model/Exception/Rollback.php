<?php
/**
 * Author: Sean Dunagan
 * Created: 10/14/15
 */

class Dunagan_ProcessQueue_Model_Exception_Rollback
    extends Exception
    implements Dunagan_ProcessQueue_Model_Task_Result_Interface
{
    // The Status of the task
    // Set to status ERROR by default
    protected $_task_status = Dunagan_ProcessQueue_Model_Task::STATUS_ERROR;
    // The status messaging of the task
    protected $_task_status_message = null;

    /**
     * Used to pass back any necessary data to the ProcessQueue task helper. Not currently used in the system
     */
    protected $_methodCallbackResult = null;

    /**
     * Denotes whether the task execution failed to the point that all related database transactions should be rolled
     *      back. If a task threw an exception inheriting this class, we assume that we need to roll back any/all
     *      database transactions related to the task execution
     *
     * @return bool
     */
    public function shouldTransactionBeRolledBack()
    {
        return true;
    }

    /**
     * Used to pass back any necessary data to the ProcessQueue task helper. Not currently used in the system
     *
     * @return mixed
     */
    public function getMethodCallbackResult()
    {
        return $this->_methodCallbackResult;
    }

    /**
     * Used to pass back any necessary data to the ProcessQueue task helper. Not currently used in the system
     *
     * @return $this
     */
    public function setMethodCallbackResult($methodCallbackResult)
    {
        $this->_methodCallbackResult = $methodCallbackResult;
        return $this;
    }

    /**
     * Returns the status of a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     * @return mixed - Expected to return one of the STATUS_* constants in class Dunagan_ProcessQueue_Model_Task
     */
    public function getTaskStatus()
    {
        return $this->_task_status;
    }

    /**
     * Sets the status of a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     * @return mixed - Expected to pass in one of the STATUS_* constants in class Dunagan_ProcessQueue_Model_Task
     */
    public function setTaskStatus($task_status)
    {
        $this->_task_status = $task_status;
        return $this;
    }

    /**
     * Returns any messaging resulting from a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     * @return mixed - string|null
     */
    public function getTaskStatusMessage()
    {
        return $this->_task_status_message;
    }

    /**
     * Sets any messaging resulting from a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     * @return $this
     */
    public function setTaskStatusMessage($task_status_message)
    {
        $this->_task_status_message = $task_status_message;
        return $this;
    }
}
