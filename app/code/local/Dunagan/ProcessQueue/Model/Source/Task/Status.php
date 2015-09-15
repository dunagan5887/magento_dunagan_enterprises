<?php
/**
 * Author: Sean Dunagan
 * Created: 9/14/15
 */

class Dunagan_ProcessQueue_Model_Source_Task_Status
{
    protected $_options = null;

    public function getAllOptions()
    {
        if (is_null($this->_options)) {
            $this->_options = array(
                array(
                    'label' => Mage::helper('dunagan_process_queue')->__('Pending'),
                    'value' => Dunagan_ProcessQueue_Model_Task::STATUS_PENDING
                ),
                array(
                    'label' => Mage::helper('dunagan_process_queue')->__('Processing'),
                    'value' => Dunagan_ProcessQueue_Model_Task::STATUS_PROCESSING
                ),
                array(
                    'label' => Mage::helper('dunagan_process_queue')->__('Complete'),
                    'value' => Dunagan_ProcessQueue_Model_Task::STATUS_COMPLETE
                ),
                array(
                    'label' => Mage::helper('dunagan_process_queue')->__('Error'),
                    'value' => Dunagan_ProcessQueue_Model_Task::STATUS_ERROR
                ),
                array(
                    'label' => Mage::helper('dunagan_process_queue')->__('Aborted'),
                    'value' => Dunagan_ProcessQueue_Model_Task::STATUS_ABORTED
                ),
            );
        }
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
            $_options[$option['value']] = $option['label'];
        }
        return $_options;
    }
} 