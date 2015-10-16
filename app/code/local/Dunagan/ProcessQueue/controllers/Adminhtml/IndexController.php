<?php
/**
 * Author: Sean Dunagan
 * Created: 9/14/15
 */

class Dunagan_ProcessQueue_Adminhtml_IndexController
    extends Dunagan_Base_Controller_Adminhtml_Form_Abstract
    implements Dunagan_Base_Controller_Adminhtml_Form_Interface
{
    const EXCEPTION_LOAD_TASK = 'An exception occurred while attempting to load the queued task with id %s to manually act on the task: %s';
    const EXCEPTION_ACT_ON_TASK = 'An error occurred while acting on the task with id %s: %s';
    const GENERIC_ADMIN_FACING_ERROR_MESSAGE = 'An error occurred with your request. Please try again.';
    const ERROR_UPDATE_STATUS_UNALLOWED = 'You do not have authorization to update the status for this task';
    const NOTICE_TASK_ACTION = 'The attempt to %s the process queue task with id %s has completed.';

    public function actOnTaskAction()
    {
        $task_id = $this->getRequest()->getParam($this->getObjectParamName());
        try
        {
            $queueTask = Mage::getModel($this->getObjectClassname())->load($task_id);
            if ((!is_object($queueTask)) || (!$queueTask->getId()))
            {
                throw new Exception('An invalid Task Id was passed to the Process Queue Controller: ' . $task_id);
            }
        }
        catch(Exception $e)
        {
            $error_message = sprintf(self::EXCEPTION_LOAD_TASK, $task_id, $e->getMessage());
            Mage::log($error_message);
            Mage::getSingleton('adminhtml/session')->addError($this->__(self::GENERIC_ADMIN_FACING_ERROR_MESSAGE));
            $exception = new Dunagan_Base_Controller_Varien_Exception($error_message);
            $exception->prepareRedirect('*/*/index');
            throw $exception;
        }

        try
        {
            $this->getQueueTaskProcessor()->processQueueTask($queueTask);
        }
        catch(Exception $e)
        {
            $error_message = sprintf(self::EXCEPTION_ACT_ON_TASK, $task_id, $e->getMessage());
            Mage::log($error_message);
            Mage::getSingleton('adminhtml/session')->addError($this->__($error_message));
            $exception = new Dunagan_Base_Controller_Varien_Exception($error_message);
            $exception->prepareRedirect('*/*/index');
            throw $exception;
        }

        $action_text = $queueTask->getActionText();
        $notice_message = sprintf(self::NOTICE_TASK_ACTION, $action_text, $task_id);
        Mage::getSingleton('adminhtml/session')->addNotice($this->__($notice_message));
        $this->_redirect('*/*/index');
    }

    /**
     * Allow Queue Tasks to be created via these forms
     *
     * @param $objectToCreate
     * @param $posted_object_data
     * @return mixed
     */
    public function validateDataAndCreateObject($objectToCreate, $posted_object_data)
    {
        $objectToCreate->setLastExecutedAt(null);
        return $objectToCreate->addData($posted_object_data);
    }

    public function validateDataAndUpdateObject($objectToUpdate, $posted_object_data)
    {
        // Only the status field should have been passed
        $new_status = isset($posted_object_data['status']) ? $posted_object_data['status'] : null;
        if (!is_null($new_status))
        {
            if (!$this->canAdminUpdateStatus())
            {
                $error_message = sprintf(self::ERROR_UPDATE_STATUS_UNALLOWED);
                Mage::getSingleton('adminhtml/session')->addError($this->__($error_message));
                $exception = new Dunagan_Base_Controller_Varien_Exception($error_message);
                $exception->prepareRedirect('*/*/index');
                throw $exception;
            }
            $objectToUpdate->setStatus($new_status);
        }

        return $objectToUpdate;
    }

    public function loadBlocksBeforeGrid()
    {
        $task_index_block_classname = $this->getCompleteClassnameBySuffix($this->getHeaderBlockName());
        $this->_addContent($this->getLayout()->createBlock($task_index_block_classname));

        return $this;
    }

    public function getQueueTaskProcessor()
    {
        return Mage::helper('dunagan_process_queue/task_processor');
    }

    public function getHeaderBlockName()
    {
        return 'adminhtml_index';
    }

    /**
     * This method expected to be overwritten
     *
     * @return bool
     */
    public function canAdminUpdateStatus()
    {
        $update_status_acl_path  = $this->getUpdateStatusACLPath();
        if (!is_null($update_status_acl_path))
        {
            return Mage::getSingleton('admin/session')->isAllowed($update_status_acl_path);
        }

        return $this->_isAllowed();
    }

    public function getUpdateStatusACLPath()
    {
        return null;
    }

    public function getModuleGroupname()
    {
        return 'dunagan_process_queue';
    }

    public function getControllerActiveMenuPath()
    {
        return 'system/dunagan_process_queue';
    }

    public function getModuleInstanceDescription()
    {
        return 'Process Queue Tasks';
    }

    public function getIndexBlockName()
    {
        return 'adminhtml_task_index';
    }

    public function getObjectParamName()
    {
        return 'task';
    }

    public function getObjectDescription()
    {
        return 'Task';
    }

    public function getModuleInstance()
    {
        return 'task';
    }

    public function getFormBlockName()
    {
        return 'adminhtml_task';
    }

    public function getIndexActionsController()
    {
        return 'adminhtml_index';
    }

    public function getFormBackControllerActionPath()
    {
        return 'adminhtml_index/index';
    }
}
