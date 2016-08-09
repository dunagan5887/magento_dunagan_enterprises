<?php
/**
 * Author: Sean Dunagan
 * Created: 04/06/2015
 *
 * Class Dunagan_Base_Block_Adminhtml_Widget_Grid_Container
 *
 * This class expects the controller to a descendant of class Worldview_Base_Controller_Adminhtml_Abstract
 */

class Dunagan_Base_Block_Adminhtml_Widget_Grid_Container
    extends Mage_Adminhtml_Block_Widget_Grid_Container
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

    public function __construct()
    {
        $module_groupname = $this->getAction()->getModuleGroupname();
        $this->_blockGroup = $module_groupname;
        $this->_controller = $this->getAction()->getIndexBlockName();

        parent::__construct();

        $this->_headerText = $this->getDefinedHeaderText();
        $this->_objectId = $this->getObjectId();

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
                    'label' => Mage::helper($module_groupname)->__($button_label),
                    'onclick' => "document.location='" .$button_action_url . "'",
                    'level' => -1
                )
            );
        }
    }


    // OPTIONAL

    public function getDefinedHeaderText()
    {
        $module_groupname = $this->getAction()->getModuleGroupname();
        $module_instance_description = $this->getAction()->getModuleInstanceDescription();
        return Mage::helper($module_groupname)->__($module_instance_description);
    }

    public function getObjectId()
    {
        return 'admin_grid_container_block_id';
    }

    // Subclass may override this class
    public function getActionButtonsToRender()
    {
        return array();
    }
}
