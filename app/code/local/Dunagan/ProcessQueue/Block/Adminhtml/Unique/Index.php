<?php
/**
 * Author: Sean Dunagan
 * Created: 9/25/15
 */

class Dunagan_ProcessQueue_Block_Adminhtml_Unique_Index
    extends Dunagan_ProcessQueue_Block_Adminhtml_Index
{
    protected function _getTaskProcessorHelper()
    {
        return Mage::helper('dunagan_process_queue/task_processor_unique');
    }
}
