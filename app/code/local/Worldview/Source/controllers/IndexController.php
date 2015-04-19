<?php

class Worldview_Source_IndexController
    extends Dunagan_Base_Controller_Adminhtml_Form_Abstract
    implements Dunagan_Base_Controller_Adminhtml_Form_Interface
{
    public function validateDataAndCreateObject($objectToCreate, $posted_object_data)
    {
        // Since adding sources currently requires admin privileges, we won't do much data validation here
        $objectToCreate->addData($posted_object_data);
        return $objectToCreate;
    }

    public function validateDataAndUpdateObject($objectToUpdate, $posted_object_data)
    {
        // Since people doing code reviews of the site will have privileges to update the 'active' setting on a source,
        // do some data validation here
        $no_hacking_occurred = $this->_assertDataIsRestrictedToFields($posted_object_data, array('active'));
        $no_required_fields_were_missing = $this->_assertRequiredFieldsAreIncluded($posted_object_data, array('active'));
        $objectToUpdate->addData($posted_object_data);
        return $objectToUpdate;
    }

    public function getModuleGroupname()
    {
        return 'worldview_source';
    }

    public function getControllerActiveMenuPath()
    {
        return 'worldview/feeds/sources';
    }

    public function getModuleInstanceDescription()
    {
        return 'Feed Sources';
    }

    public function getIndexBlockName()
    {
        return 'adminhtml_source_index';
    }

    public function getObjectParamName()
    {
        return 'source';
    }

    public function getObjectDescription()
    {
        return 'Feed Source';
    }

    public function getModuleInstance()
    {
        return 'source';
    }

    public function getFormBlockName()
    {
        return 'adminhtml_source';
    }

    public function getFormActionsController()
    {
        return 'index';
    }
}
