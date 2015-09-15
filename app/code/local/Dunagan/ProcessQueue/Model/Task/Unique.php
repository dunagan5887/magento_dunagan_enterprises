<?php
/**
 * Author: Sean Dunagan
 * Created: 8/22/15
 */

class Dunagan_ProcessQueue_Model_Task_Unique
    extends Dunagan_ProcessQueue_Model_Task
{
    public function _construct()
    {
        $this->_init('dunagan_process_queue/task_unique', 'task_id');
    }
}
