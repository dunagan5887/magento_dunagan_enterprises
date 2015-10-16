<?php
/**
 * Author: Sean Dunagan
 * Created: 9/14/15
 */

require_once('Dunagan/ProcessQueue/controllers/Adminhtml/IndexController.php');
class Dunagan_ProcessQueue_Adminhtml_Unique_IndexController
    extends Dunagan_ProcessQueue_Adminhtml_IndexController
    implements Dunagan_Base_Controller_Adminhtml_Form_Interface
{
    public function getQueueTaskProcessor()
    {
        return Mage::helper('dunagan_process_queue/task_processor_unique');
    }

    public function getHeaderBlockName()
    {
        return 'adminhtml_unique_index';
    }

    public function getControllerActiveMenuPath()
    {
        return 'system/dunagan_process_queue_unique';
    }

    public function getModuleInstanceDescription()
    {
        return 'Unique Process Queue Tasks';
    }

    public function getIndexBlockName()
    {
        return 'adminhtml_task_unique_index';
    }

    public function getObjectParamName()
    {
        return 'unique_task';
    }

    public function getObjectDescription()
    {
        return 'Unique Task';
    }

    public function getModuleInstance()
    {
        return 'task_unique';
    }

    public function getFormBlockName()
    {
        return 'adminhtml_task_unique';
    }

    public function getIndexActionsController()
    {
        return 'adminhtml_unique_index';
    }

    public function getFormBackControllerActionPath()
    {
        return 'adminhtml_unique_index/index';
    }
}
