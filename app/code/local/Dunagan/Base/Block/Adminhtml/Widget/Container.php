<?php
/**
 * Author: Sean Dunagan
 * Created: 4/11/15
 *
 * class Dunagan_Base_Block_Adminhtml_Widget_Container
 */

abstract class Dunagan_Base_Block_Adminhtml_Widget_Container
    extends Mage_Adminhtml_Block_Widget_Container
    implements Dunagan_Base_Block_Adminhtml_Widget_Container_Interface
{
    /**
     * This class assumes that the controller loading it extends the
     *      Dunagan_Base_Controller_Adminhtml_Abstract class
     *
     * @return Dunagan_Base_Controller_Adminhtml_Abstract
     */
    public function getAction()
    {
        return parent::getAction();
    }

    /**
     * The text which should head the page
     *
     * @return string
     */
    abstract public function getDefinedHeaderText();

    public function getObjectId()
    {
        return 'admin_container_block_id';
    }

    public function getActionButtonsToRender()
    {
        return array();
    }
    
    public function __construct()
    {
        $this->_headerText = $this->getDefinedHeaderText();
        $block_module_groupname = $this->getAction()->getModuleGroupname();

        $this->_objectId = $this->getObjectId();
        $this->setTemplate('widget/view/container.phtml');

        parent::__construct();

        $action_buttons_array = $this->getActionButtonsToRender();

        foreach ($action_buttons_array as $button_id => $button_data)
        {
            $button_action_url = isset($button_data['action_url']) ? $button_data['action_url'] : '';
            if (empty($button_action_url))
            {
                // Url must be defined
                continue;
            }

            $button_label = isset($button_data['label']) ? $button_data['label'] : '';
            if (empty($button_label))
            {
                // Label must be defined
                continue;
            }

            $this->_addButton(
                $button_id, array(
                    'label' => Mage::helper($block_module_groupname)->__($button_label),
                    'onclick' => "document.location='" .$button_action_url . "'",
                    'level' => -1
                )
            );
        }
    }
}
