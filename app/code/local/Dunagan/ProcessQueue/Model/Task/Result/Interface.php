<?php
/**
 * Author: Sean Dunagan
 * Created: 8/14/15
 */

interface Dunagan_ProcessQueue_Model_Task_Result_Interface
{
    /**
     * Returns the status of a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     * @return mixed - Expected to return one of the STATUS_* constants in class Dunagan_ProcessQueue_Model_Task
     */
    public function getTaskStatus();

    /**
     * Sets the status of a Dunagan_ProcessQueue_Model_Task::executeTask() call
     *
     * @return mixed - Expected to pass in one of the STATUS_* constants in class Dunagan_ProcessQueue_Model_Task
     */
    public function setTaskStatus($status);

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