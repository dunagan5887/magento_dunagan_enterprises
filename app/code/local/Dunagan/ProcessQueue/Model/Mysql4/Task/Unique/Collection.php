<?php
/**
 * Author: Sean Dunagan
 * Created: 8/13/15
 * Class Dunagan_ProcessQueue_Model_Mysql_Task_Collection
 */

class Dunagan_ProcessQueue_Model_Mysql4_Task_Unique_Collection extends Dunagan_ProcessQueue_Model_Mysql4_Task_Collection
{
    protected function _construct()
    {
        $this->_init('dunagan_process_queue/task_unique');
    }
}
