<?php
/**
 * Author: Sean Dunagan
 * Created: 9/14/15
 */

class Dunagan_ProcessQueue_Adminhtml_IndexController
    extends Dunagan_Base_Controller_Adminhtml_Form_Abstract
    implements Dunagan_Base_Controller_Adminhtml_Form_Interface
{
    const ERROR_UPDATE_STATUS_UNALLOWED = 'You do not have authorization to update the status for this task';

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

    public function getFormActionsController()
    {
        return 'adminhtml_index';
    }

    public function getFormBackControllerActionPath()
    {
        return 'adminhtml_index/index';
    }
}
