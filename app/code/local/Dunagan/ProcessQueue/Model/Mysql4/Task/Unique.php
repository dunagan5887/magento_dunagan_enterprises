<?php
/**
 * Author: Sean Dunagan
 * Created: 8/22/15
 */

class Dunagan_ProcessQueue_Model_Mysql4_Task_Unique
    extends Dunagan_ProcessQueue_Model_Mysql4_Task
{
    public function _construct()
    {
        $this->_init('dunagan_process_queue/task_unique', 'task_id');
    }

    protected function _getUniqueInsertDataArrayTemplate($code, $object, $method, $unique_id)
    {
        $insert_data_array_template = parent::_getInsertDataArrayTemplate($code, $object, $method);
        $insert_data_array_template['unique_id'] = $unique_id;
        return $insert_data_array_template;
    }

    protected function _getInsertColumnsArray()
    {
        return array('code', 'unique_id', 'status', 'object', 'method', 'serialized_arguments_object');
    }
}
