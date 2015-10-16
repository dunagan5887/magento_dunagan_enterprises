<?php
/**
 * Author: Sean Dunagan
 * Created: 4/7/15
 *
 * Interface Dunagan_Base_Controller_Adminhtml_Interface
 */

interface Dunagan_Base_Controller_Adminhtml_Interface
{
    // The following methods are required. They will provide basic indexAction functionality
    /**
     * Should be the groupname of the module extending this class.
     *  e.g.
     *      <config>
     *          <global>
     *              <models|blocks|helpers>
     *                  <dunagan_base>  <-- Should be this value
     *
     * This same value should also be used for the frontname of the routers used for
     *  this controller
     *
     * @return string
     */
    public function getModuleGroupname();

    /**
     * For whatever object is being edited/saved/deleted by this controller, this should be what comes
     * after the module's groupname in the object's full classname
     *  e.g.    catalog/product <--- would be "product" in this case
     *
     * @return string
     */
    public function getModuleInstance();

    /**
     * Should be the controller that will process the index actions
     * e.g. if the url for the index action is {frontname}/{controller}/index
     *              then this method should return the {controller} value
     *
     * @return string
     */
    public function getIndexActionsController();

    /**
     * Should be the name of whatever parameter will pass the object to be
     * created/edited/deleted's id to the controller
     *
     * @return string
     */
    public function getObjectParamName();

    /**
     * Should be the path to the menu item
     *  e.g. in adminhtml.xml
     * <?xml version="1.0"?>
     * <config>
            <menu>
                <path_node_1>
                    <children>
                        <path_node_2 translate="title" module="module groupname referenced above in getModuleGroupname">
                                <children>
                                    <path_node_3>
     *
     * This value would be path_node_1/path_node_2/path_node_3
     *
     * @return string
     */
    public function getControllerActiveMenuPath();

    /**
     * Should be a human readable description of the controller's object/purpose
     * e.g. Product or Report
     *
     * @return string
     */
    public function getModuleInstanceDescription();

    /**
     * Should be the block name of whatever block is to be initialized to load the controller's
     * index action layout
     *
     * e.g.
     *  If the block to load the page's layout is "adminhtml/sales_order" then
     *  this method should return "sales_order"
     *
     * @return string
     */
    public function getIndexBlockName();


    // OPTIONAL

    // The following methods are OPTIONAL for classes which inherit from Dunagan_Base_Controller_Adminhtml_Abstract
    /**
     * Allows for subclasses to define a custom ACL path for the controller.
     *
     *
     * @return string - By default, the Dunagan_Base_Controller_Adminhtml_Abstract class will use the value defined by
     *                      getControllerActiveMenuPath()
     */
    public function getAclPath();

    /**
     * Allows for creating blocks to be shown on the page above the grid
     *
     * @return $this - By default, the Dunagan_Base_Controller_Adminhtml_Abstract does nothing in this method
     */
    public function loadBlocksBeforeGrid();

    /**
     * Allows for creating blocks to be shown on the page below the grid
     *
     * @return $this - By default, the Dunagan_Base_Controller_Adminhtml_Abstract does nothing in this method
     */
    public function loadBlocksAfterGrid();
}