<?php
/**
 * Author: Sean Dunagan
 * Created: 4/7/15
 *
 * class Dunagan_Base_Block_Adminhtml_Widget_Form
 */

abstract class Dunagan_Base_Block_Adminhtml_Widget_Form
    extends Mage_Adminhtml_Block_Widget_Form
    implements Dunagan_Base_Block_Adminhtml_Widget_Form_Interface
{
    /**
     * This class assumes that the controller loading it extends the
     *      Dunagan_Base_Controller_Adminhtml_Form_Abstract class
     *
     * @return Dunagan_Base_Controller_Adminhtml_Form_Abstract
     */
    public function getAction()
    {
        return parent::getAction();
    }

    const FORM_ELEMENT_FIELD_NAME_TEMPLATE = '%s[%s]';

    abstract public function populateFormFieldset(Varien_Data_Form_Element_Fieldset $fieldset);

    protected function _prepareForm()
    {
        $controllerAction = $this->getAction();
        $helper = $controllerAction->getModuleHelper();

        $form = new Varien_Data_Form(array('id' => 'edit_form', 'action' => $this->getActionUrl(), 'method' => 'post'));
        $form->setUseContainer(true);
        $html_id_prefix = $controllerAction->getModuleGroupname() . '_';
        $form->setHtmlIdPrefix($html_id_prefix);

        $fieldset = $form->addFieldset(
            'base_fieldset',
            array('legend' => $helper->__($controllerAction->getObjectDescription()), 'class'=>'fieldset-wide')
        );

        $object_id_element_name = $controllerAction->getObjectParamName();

        $object_id = $this->_isObjectBeingEdited() ? $this->_getObjectToEdit()->getId() : '';
        $fieldset->addField($object_id_element_name, 'hidden', array(
            'name' => $object_id_element_name,
            'value' => $object_id
        ));

        $this->populateFormFieldset($fieldset);

        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function getActionUrl()
    {
        $uri_path = $this->getAction()->getUriPathForFormAction('save');
        return $this->getUrl($uri_path);
    }

    protected function _addTextFieldEditableIfNewOnly(Varien_Data_Form_Element_Fieldset $fieldset, $field, $label, $required = true)
    {
        if ($this->_isObjectBeingEdited())
        {
            $this->_addNonEditableTextField($fieldset, $field, $label, $required);
        }
        else
        {
            $this->_addEditableTextField($fieldset, $field, $label, $required);
        }
    }

    protected function _addEditableTextField(Varien_Data_Form_Element_Fieldset $fieldset, $field, $label, $required = true)
    {
        $helper = $this->getAction()->getModuleHelper();

        $fieldset->addField($field, 'text', array(
            'name'  => $this->_getFormElementName($field),
            'label' => $helper->__($label),
            'title' => $helper->__($label),
            'value'  => $this->_getValueIfObjectIsSet($field),
            'required' => ((bool)$required)
        ));
    }

    protected function _addNonEditableTextField(Varien_Data_Form_Element_Fieldset $fieldset, $field, $label)
    {
        $helper = $this->getAction()->getModuleHelper();

        $fieldset->addField($field, 'note', array(
            'name'  => $field,
            'label' => $helper->__($label),
            'title' => $helper->__($label),
            'text'  => $this->_getValueIfObjectIsSet($field)
        ));
    }

    protected function _addEditableTextareaField(Varien_Data_Form_Element_Fieldset $fieldset, $field, $label, $required = true)
    {
        $helper = $this->getAction()->getModuleHelper();

        $fieldset->addField($field, 'textarea', array(
            'name'  => $this->_getFormElementName($field),
            'label' => $helper->__($label),
            'title' => $helper->__($label),
            'value'  => $this->_getValueIfObjectIsSet($field),
            'required' => ((bool)$required)
        ));
    }

    /**
     * There is no _addNonEditableSelectField because having an uneditable dropdown rarely makes sense
     * from a UX perspective
     *
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     * @param $field
     * @param $label
     * @param array $options - Options for the select element
     * @param bool $required - Defaults to true
     */
    protected function _addEditableSelectField
                (Varien_Data_Form_Element_Fieldset $fieldset, $field, $label, array $options, $required = true)
    {
        $helper = $this->getAction()->getModuleHelper();

        $fieldset->addField($field, 'select', array(
            'name'  => $this->_getFormElementName($field),
            'label' => $helper->__($label),
            'title' => $helper->__($label),
            'value'  => $this->_getValueIfObjectIsSet($field),
            'values'   => $options,
            'required' => $required
        ));
    }

    protected function _addEditableBooleanSelectField(Varien_Data_Form_Element_Fieldset $fieldset,
                                                      $field, $label, $required = true)
    {
        $boolean_options = Mage::getModel('eav/entity_attribute_source_boolean')->getAllOptions();
        $this->_addEditableSelectField($fieldset, $field, $label, $boolean_options, $required);
    }

    protected function _getFormElementName($field)
    {
        $array_name = $this->getAction()->getFormElementArrayName();
        return sprintf(self::FORM_ELEMENT_FIELD_NAME_TEMPLATE, $array_name, $field);
    }

    protected function _getValueIfObjectIsSet($field)
    {
        return $this->_isObjectBeingEdited()
                    ?  $this->_getObjectToEdit()->getData($field)
                    : '';
    }

    protected function _isObjectBeingEdited()
    {
        return (is_object($this->_getObjectToEdit()) && $this->_getObjectToEdit()->getId());
    }

    protected function _getObjectToEdit()
    {
        return $this->getAction()->getObjectToEdit();
    }
}
