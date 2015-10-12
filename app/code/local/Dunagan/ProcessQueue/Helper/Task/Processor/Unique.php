<?php
/**
 * Author: Sean Dunagan
 * Created: 8/22/15
 */

class Dunagan_ProcessQueue_Helper_Task_Processor_Unique
    extends Dunagan_ProcessQueue_Helper_Task_Processor
{
    protected $_task_model_classname = 'dunagan_process_queue/task_unique';
    protected $_task_resource_classname = 'dunagan_process_queue/task_unique';

    /**
     * @param string $code - The task's process code
     * @param string $object - Class of the object to call the task callback method on
     * @param string $method - The callback method to be called
     * @param stdClass $argumentsObject - Object containing the arguments for the task callback
     * @return Dunagan_ProcessQueue_Model_Task
     */
    public function createUniqueQueueTaskInProcessingState($code, $object, $method, $argumentsObject, $unique_id)
    {
        // Construct the data array for the queue Task
        $insert_data_array_template = $this->_getTaskResourceSingleton()
                                            ->getUniqueInsertDataArrayTemplate($code, $object, $method, $unique_id);
        $insert_data_array_template['serialized_arguments_object'] = $argumentsObject;
        // Create the task model and initialize the fields
        $taskObject = Mage::getModel($this->_task_model_classname)->setData($insert_data_array_template);
        // Set the status as PROCESSING so that there is no race condition with the crontab picking up the task
        //      since the calling block wants to process the task immediately
        $taskObject->setStatus(Dunagan_ProcessQueue_Model_Task::STATUS_PROCESSING);
        $taskObject->save();
        return $taskObject;
    }
} 