<?php
/**
 * Author: Sean Dunagan
 * Created: 4/11/15
 *
 * interface Dunagan_Base_Block_Adminhtml_Widget_Container_Interface
 */

interface Dunagan_Base_Block_Adminhtml_Widget_Container_Interface
{
    // The following method is REQUIRED for any class implementing Dunagan_Base_Block_Adminhtml_Widget_Container_Interface
    /**
     * Is the header text to be displayed on the page
     *
     * @return mixed
     */
    public function getDefinedHeaderText();

    // OPTIONAL


    // The following methods are OPTIONAL for any class inheriting from abstract class Dunagan_Base_Block_Adminhtml_Widget_Container
    // They may be overridden to redefine functionality

    /**
     * Id of the container block to be rendered. May be useful for styling purposes
     *
     * @return string - by default Dunagan_Base_Block_Adminhtml_Widget_Container will return 'admin_container_block_id'
     */
    public function getObjectId();

    /**
     * Should return an array containing the buttons to be added to the container
     * array should be of the form
     *
     * array(
     *      'button_id' => array('action_url' => 'COMPLETE_url_defining_action_to_take_on_button_press'
     *                              'label' => 'label of the button on the page'),
     *
     *      'other_button_id' => array('action_url' => 'COMPLETE_url_defining_action_to_take_on_other_button_press'
     *                              'label' => 'label of the other button on the page'),
     *      ...
     *      ...
     *      ...
     *      ...
     * )
     *
     * THE URLS PASSED IN MUST BE FULLY FORMED URLS, NOT URIs OR CONTROLLER ACTION PATHS
     *
     * @return array - by default Dunagan_Base_Block_Adminhtml_Widget_Container will return an empty array
     */
    public function getActionButtonsToRender();
}
