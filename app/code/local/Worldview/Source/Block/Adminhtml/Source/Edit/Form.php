<?php
/**
 * Author: Sean Dunagan
 * Created: 4/7/15
 *
 * class Worldview_Source_Block_Adminhtml_Source_Form
 */

class Worldview_Source_Block_Adminhtml_Source_Edit_Form
    extends Dunagan_Base_Block_Adminhtml_Widget_Form
    implements Dunagan_Base_Block_Adminhtml_Widget_Form_Interface
{
    public function populateFormFieldset(Varien_Data_Form_Element_Fieldset $fieldset)
    {
        // Currently editing of sources via admin panel is disallowed except for active
        // Admins with proper rights can add new sources
        $this->_addTextFieldEditableIfNewOnly($fieldset, 'code', 'Code');
        $this->_addTextFieldEditableIfNewOnly($fieldset, 'name', 'Name');
        $this->_addTextFieldEditableIfNewOnly($fieldset, 'feed_url', 'Feed Url');
        $this->_addTextFieldEditableIfNewOnly($fieldset, 'category', 'Category');
        $this->_addTextFieldEditableIfNewOnly($fieldset, 'type', 'Type');

        // The 'active' flag should always be editable
        $active_options = Mage::getModel('eav/entity_attribute_source_boolean')->getAllOptions();
        $this->_addEditableSelectField($fieldset, 'active', 'Active', $active_options);
    }
}
