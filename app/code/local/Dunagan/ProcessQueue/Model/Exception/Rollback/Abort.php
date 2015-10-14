<?php
/**
 * Author: Sean Dunagan
 * Created: 10/14/15
 */

class Dunagan_ProcessQueue_Model_Exception_Rollback_Abort extends Dunagan_ProcessQueue_Model_Exception_Rollback
{
    protected $_task_status = Dunagan_ProcessQueue_Model_Task::STATUS_ABORTED;
}
