<?php
/**
 * Author: Sean Dunagan
 * Created: 8/13/15
 * Class Dunagan_ProcessQueue_Helper_Processor
 */

class Dunagan_ProcessQueue_Helper_Task_Processor extends Mage_Core_Helper_Data
{
    const EXCEPTION_UPDATE_AS_PROCESSING = 'An exception occurred while attempting to update queue task with id %s as processing: %s';
    const EXCEPTION_SELECT_FOR_UPDATE = 'An uncaught exception occurred while attempting to select queue task with id %s for update: %s';
    const ERROR_FAILED_TO_SELECT_FOR_UPDATE = 'Failed to select queue task with id %s for update';
    const EXCEPTION_EXECUTING_TASK = 'An uncaught exception occurred while executing task for queue task object with id %s: %s';
    const EXCEPTION_ACTING_ON_TASK_RESULT = 'An exception occurred while acting on the task result for task with id %s: %s';
    const EXCEPTION_COMMITTING_TRANSACTION = 'An uncaught exception occurred when attempting to commit the transaction for process queue object with id %s: %s';
    const EXCEPTION_UPDATING_LAST_EXECUTED_FOR_PRIOR_PROCESSING_TASK = 'An exception occurred while attempting to update the last_executed_at timestamp and clear the status message for the task with id %s: %s';

    protected $_moduleName = 'dunagan_process_queue';
    protected $_logModel = null;
    protected $_taskResourceSingleton = null;

    protected $_task_model_classname = 'dunagan_process_queue/task';
    protected $_task_resource_classname = 'dunagan_process_queue/task';

    protected $_batch_size = 2500;

    // TODO Create separate database connection for queue task resource Singleton
    public function processQueueTasks($code = null)
    {
        $processQueueTaskCollection = $this->getQueueTasksForProcessing($code);

        // Update the last_executed_at value for these task rows so that the next cron iteration will pick up a different
        //  set of BATCH_SIZE rows from the call to $this->getQueueTasksForProcessing($code); above
        $this->updateLastExecutedAtToCurrentTime($processQueueTaskCollection);

        foreach ($processQueueTaskCollection as $processQueueTaskObject)
        {
            $this->processQueueTask($processQueueTaskObject);
        }
    }

    /**
     * Executes the following:
     *  - Attempts to update task object's row as processing
     *  - If successful, Begins a database transaction
     *  - Attempts to select that row for update
     *  - If successful, attempts to execute method callback defined in row, returning a result object
     *  - Updates the task object based on the resulting object
     *  - Commits the database transaction
     *
     * @param Dunagan_ProcessQueue_Model_Task_Interface $processQueueTaskObject
     * @param boolean $row_has_already_been_set_as_processing - Has this task object already been set as processing?
     *                                                              This typically denotes that whatever process created
     *                                                              the task object wants to ensure that it is also the
     *                                                              process which executes the task
     * @return Dunagan_ProcessQueue_Model_Task_Result_Interface|null - Returns an object implementing interface
     *                                                                  Dunagan_ProcessQueue_Model_Task_Result_Interface
     *                                                                  if execution did not throw an uncaught exception
     *                                                                Returns null if the task was unable to be selected
     *                                                                  for processing (another thread has likely already
     *                                                                  begun processing the task) or if an uncaught
     *                                                                  exception was thrown
     */
    public function processQueueTask(Dunagan_ProcessQueue_Model_Task_Interface $processQueueTaskObject,
                                        $row_has_already_been_set_as_processing = false)
    {
        if (!$row_has_already_been_set_as_processing)
        {
            try {
                $able_to_lock_for_processing = $processQueueTaskObject->attemptUpdatingRowAsProcessing();
                if (!$able_to_lock_for_processing) {
                    // Assume another thread of execution is already processing this task
                    return null;
                }
            } catch (Exception $e) {
                $error_message = $this->__(self::EXCEPTION_UPDATE_AS_PROCESSING, $processQueueTaskObject->getId(), $e->getMessage());
                $this->_logError($error_message);
                return null;
            }
        }
        else
        {
            // Don't attempt to update the status as PROCESSING, but set the task last executed at time, as well as
            //      clear out the existing status message
            $task_id = $processQueueTaskObject->getId();
            try
            {
                $this->_getTaskResourceSingleton()->updateLastExecutedAtToCurrentTime(array($task_id), true);
            }
            catch(Exception $e)
            {
                $error_message = $this->__(self::EXCEPTION_UPDATING_LAST_EXECUTED_FOR_PRIOR_PROCESSING_TASK, $task_id, $e->getMessage());
                $this->_logError($error_message);
                // Do not interrupt processing of the task due to an exception thrown here
            }
        }

        // At this point, start transaction and lock row for update to ensure exclusive access
        $taskResourceSingleton = $processQueueTaskObject->getResource();
        $taskResourceSingleton->beginTransaction();
        try
        {
            $selected = $processQueueTaskObject->selectForUpdate();
            if (!$selected)
            {
                // Assume another thread has already locked this task object's row, although this shouldn't happen
                $taskResourceSingleton->rollBack();
                $error_message = $this->__(self::ERROR_FAILED_TO_SELECT_FOR_UPDATE, $processQueueTaskObject->getId());
                $this->_logError($error_message);

                return null;
            }
        }
        catch(Exception $e)
        {
            $taskResourceSingleton->rollBack();
            $error_message = $this->__(self::EXCEPTION_SELECT_FOR_UPDATE, $processQueueTaskObject->getId(), $e->getMessage());
            $this->_logError($error_message);
            return null;
        }

        try
        {
            $taskExecutionResult = $processQueueTaskObject->executeTask();
        }
        catch(Dunagan_ProcessQueue_Model_Exception_Rollback $taskExecutionResult)
        {
            // Rollback the transaction to prevent any orphaned/corrupt data from persisting in the system
            $taskResourceSingleton->rollBack();
            // We still want the task to update its status and status message fields according to the task execution,
            //      so we continue the execution of this method
        }
        catch(Exception $e)
        {
            // If the task execution threw an uncaught exception, rollback the transaction and return error status
            $taskResourceSingleton->rollBack();
            $error_message = $this->__(self::EXCEPTION_EXECUTING_TASK, $processQueueTaskObject->getId(), $e->getMessage());
            $processQueueTaskObject->setTaskAsErrored($error_message);
            $this->_logError($error_message);
            return null;
        }

        try
        {
            $processQueueTaskObject->actOnTaskResult($taskExecutionResult);
        }
        catch(Exception $e)
        {
            // At this point, we would assume that the task has been performed successfully since executeTask() did not
            //  throw any exceptions. As such, log the exception but commit the transaction. Even if this leaves a row
            //  in the PROCESSING state, it's better than leaving parts of the database out of sync with external resources
            $error_message = $this->__(self::EXCEPTION_ACTING_ON_TASK_RESULT, $processQueueTaskObject->getId(), $e->getMessage());
            $this->_logError($error_message);
        }

        try
        {
            // Check to ensure that a rollback transaction exception was not thrown
            if (!$taskExecutionResult->shouldTransactionBeRolledBack())
            {
                $taskResourceSingleton->commit();
            }
        }
        catch(Exception $e)
        {
            // If an exception occurs here, rollback
            $taskResourceSingleton->rollback();
            $processQueueTaskObject->setTaskAsErrored();
            $error_message = $this->__(self::EXCEPTION_COMMITTING_TRANSACTION, $processQueueTaskObject->getId(), $e->getMessage());
            $this->_logError($error_message);
        }

        return $taskExecutionResult;
    }

    /**
     * @param string $code - The task's process code
     * @param string $object - Class of the object to call the task callback method on
     * @param string $method - The callback method to be called
     * @param stdClass $argumentsObject - Object containing the arguments for the task callback
     * @return Dunagan_ProcessQueue_Model_Task
     */
    public function createQueueTaskInProcessingState($code, $object, $method, $argumentsObject)
    {
        // Construct the data array for the queue Task
        $insert_data_array_template = $this->_getTaskResourceSingleton()
                                            ->getInsertDataArrayTemplate($code, $object, $method);
        $insert_data_array_template['serialized_arguments_object'] = $argumentsObject;
        // Create the task model and initialize the fields
        $taskObject = Mage::getModel($this->_task_model_classname)->setData($insert_data_array_template);
        // Set the status as PROCESSING so that there is no race condition with the crontab picking up the task
        //      since the calling block wants to process the task immediately
        $taskObject->setStatus(Dunagan_ProcessQueue_Model_Task::STATUS_PROCESSING);
        $taskObject->save();
        return $taskObject;
    }

    public function getCompletedAndAllQueueTasks($code = null)
    {
        $allProcessQueueTaskCollection = $this->_getTaskCollectionModel()
                                                ->setOrder('last_executed_at', Zend_Db_Select::SQL_DESC);;

        if (!empty($code))
        {
            $allProcessQueueTaskCollection->addCodeFilter($code);
        }

        $all_process_queue_tasks = $allProcessQueueTaskCollection->getItems();

        $completedTasksCollection = $this->_getTaskCollectionModel()
                                        ->addStatusFilter(Dunagan_ProcessQueue_Model_Task::STATUS_COMPLETE)
                                        ->setOrder('last_executed_at', Zend_Db_Select::SQL_DESC);

        if (!empty($code))
        {
            $completedTasksCollection->addCodeFilter($code);
        }

        $completed_queue_tasks = $completedTasksCollection->getItems();

        return array($completed_queue_tasks, $all_process_queue_tasks);
    }

    public function getQueueTasksForProgressScreen($code = null)
    {
        $processQueueTaskCollection = $this->_getTaskCollectionModel()
            ->addOpenForProcessingFilter()
            ->sortByLeastRecentlyExecuted();

        if (!empty($code))
        {
            $processQueueTaskCollection->addCodeFilter($code);
        }

        return $processQueueTaskCollection;
    }

    public function getQueueTasksForProcessing($code = null)
    {
        $processQueueTaskCollection = Mage::getModel($this->_task_model_classname)
                                        ->getCollection()
                                        ->addOpenForProcessingFilter()
                                        ->addLastExecutedAtThreshold()
                                        ->sortByLeastRecentlyExecuted()
                                        ->setPageSize($this->_batch_size);

        if (!empty($code))
        {
            $processQueueTaskCollection->addCodeFilter($code);
        }

        return $processQueueTaskCollection;
    }

    protected function _getTaskCollectionModel()
    {
        return Mage::getModel($this->_task_model_classname)->getCollection();
    }

    public function updateLastExecutedAtToCurrentTime(Dunagan_ProcessQueue_Model_Mysql4_Task_Collection $processQueueTaskCollection)
    {
        $task_objects_array = $processQueueTaskCollection->getItems();
        $task_ids = array();
        foreach ($task_objects_array as $taskObject)
        {
            $task_ids[] = $taskObject->getTaskId();
        }
        $rows_updated = $processQueueTaskCollection->getResource()->updateLastExecutedAtToCurrentTime($task_ids);
        return $rows_updated;
    }

    /**
     * Accessor for the Task Resource Model
     *
     * @return Dunagan_ProcessQueue_Model_Mysql4_Task
     */
    protected function _getTaskResourceSingleton()
    {
        if (is_null($this->_taskResourceSingleton))
        {
            $this->_taskResourceSingleton = Mage::getResourceSingleton($this->_task_resource_classname);
        }

        return $this->_taskResourceSingleton;
    }

    protected function _logError($error_message)
    {
        $exceptionToLog = new Exception($error_message);
        $this->_getLogModel()->logQueueProcessorException($exceptionToLog);
    }

    protected function _getLogModel()
    {
        if (is_null($this->_logModel))
        {
            $this->_logModel = Mage::getSingleton('dunagan_process_queue/log');
        }

        return $this->_logModel;
    }
}
