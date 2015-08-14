<?php
/**
 * Author: Sean Dunagan
 * Created: 8/13/15
 * Class Dunagan_ProcessQueue_Model_Mysql_Task_Collection
 */

class Dunagan_ProcessQueue_Model_Mysql4_Task_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('dunagan_process_queue/task');
    }

    public function addOpenForProcessingFilter()
    {
        $pending_status = Dunagan_ProcessQueue_Model_Task::STATUS_PENDING;
        $error_status = Dunagan_ProcessQueue_Model_Task::STATUS_ERROR;
        $open_for_processing_states = array($pending_status, $error_status);

        $this->addFieldToFilter('status', array('in' => $open_for_processing_states));
        return $this;
    }

    public function addCodeFilter($code)
    {
        $this->addFieldToFilter('code', $code);
        return $this;
    }

    public function sortByLeastRecentlyExecuted()
    {
        $this->getSelect()->order('last_executed_at ' . Zend_Db_Select::SQL_ASC);
        return $this;
    }
}
