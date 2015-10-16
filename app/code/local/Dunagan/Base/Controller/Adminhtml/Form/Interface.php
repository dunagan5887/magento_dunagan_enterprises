<?php
/**
 * Author: Sean Dunagan
 * Created: 4/7/15
 *
 * Interface Dunagan_Base_Controller_Adminhtml_Form_Interface
 *
 * NOTE: This interface assumes that the block used to render the form container for these actions will descend from
 *          Dunagan_Base_Block_Adminhtml_Widget_Form_Container
 */

interface Dunagan_Base_Controller_Adminhtml_Form_Interface
    extends Dunagan_Base_Controller_Adminhtml_Interface
{
    // The following methods are REQUIRED for all leaf classes which implement this interface
    /**
     * This method should inspect the data being posted and validate it. If it is valid, it should set
     *  the data on $objectToCreate
     *
     * @param $objectToCreate - New object being created
     * @param $posted_object_data
     * @return $objectToCreate - Should return the object which was passed in with data initialized appropriately.
     *                          If there is an error with the data, should throw exception of type Dunagan_Base_Model_Adminhtml_Exception
     */
    public function validateDataAndCreateObject($objectToCreate, $posted_object_data);

    /**
     * This method should inspect the data being posted and validate it. If it is valid, it should set
     *  the data on $objectToUpdate
     *
     * @param $objectToUpdate - Existing object being updated
     * @param $posted_object_data
     * @return $objectToUpdate - Should return the object which was passed in with data updated appropriately.
     *                          If there is an error with the data, should throw exception of type Dunagan_Base_Model_Adminhtml_Exception
     */
    public function validateDataAndUpdateObject($objectToUpdate, $posted_object_data);

    /**
     * Should be a human readable description of what object this form is
     *  creating/editing/deleting. This will likely be the same value as
     *  Dunagan_Base_Controller_Adminhtml_Interface::getModuleInstanceDescription()
     *
     * e.g. Product or Category
     *
     * @return string
     */
    public function getObjectDescription();

    /**
     * Should return the name of the block which will be rendered in the content section of the form action page.
     * The block which the controller loads will have the following form:
     *          {getModuleGroupname()}/{getFormBlockName()}_edit
     *
     * So this method should return the {getFormBlockName()} value.
     * This system assumes that the block being loaded has a classname ending in "_Edit"
     *
     * @return string
     */
    public function getFormBlockName();

    /**
     * Should be the controller that will process the form actions
     * e.g. if the url for the save action is {frontname}/{controller}/save
     *              then this method should return the {controller} value
     *
     * @return string
     */
    public function getFormActionsController();

    // OPTIONAL

    // The following methods are OPTIONAL for classes which inherit from Dunagan_Base_Controller_Adminhtml_Form_Abstract

    /**
     * Should be the controller that will process the form actions
     * e.g. if the url for the save action is {frontname}/{controller}/{action}
     *
     *              then this method should return the {controller}/{action} value
     *
     * abstract class Dunagan_Base_Controller_Adminhtml_Form_Abstract returns 'index/index' by default
     * Override this method if another uri should be used
     *
     * @return string
     */
    public function getFormBackControllerActionPath();

    /**
     * Defines the element array name for the object being created/updated in the form
     *
     * @return string - By default, Dunagan_Base_Controller_Adminhtml_Form_Abstract will return
     *                      $this->getObjectParamName() . '_data'
     */
    public function getFormElementArrayName();
}
