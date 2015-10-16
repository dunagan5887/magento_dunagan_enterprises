<?php
/**
 * Author: Sean Dunagan
 * Created: 4/7/15
 *
 * class Dunagan_Base_Block_Adminhtml_Widget_Form_Container
 *
 * This class expects the controller to a descendant of class Dunagan_Base_Controller_Adminhtml_Form_Abstract
 */

class Dunagan_Base_Block_Adminhtml_Widget_Form_Container
    extends Mage_Adminhtml_Block_Widget_Form_Container
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

    public function __construct()
    {
        $controllerAction = $this->getAction();
        $this->_objectId = $controllerAction->getObjectParamName();
        $this->_controller = $controllerAction->getFormBlockName();
        $this->_blockGroup = $controllerAction->getModuleGroupname();

        parent::__construct();
    }

    public function getFormActionUrl()
    {
        $uri_path = $this->getAction()->getUriPathForFormAction('save');
        return $this->getUrl($uri_path);
    }

    public function getBackUrl()
    {
        $back_uri_path = $this->getAction()->getFullBackControllerActionPath();
        return $this->getUrl($back_uri_path);
    }

    public function getHeaderText()
    {
        $controllerAction = $this->getAction();
        $pageTitle = $this->getPageTitleToRender();
        $groupname = $controllerAction->getModuleGroupname();

        if (!empty($pageTitle))
        {
            return Mage::helper($groupname)->__($pageTitle);
        }

        // We expect the $pageTitle to be passed in, but prepare for the case where it's not
        $objectToEdit = $controllerAction->getObjectToEdit();
        $object_description = $this->getAction()->getObjectDescription();

        if (is_object($objectToEdit) && $objectToEdit->getId())
        {
            $header_text = 'Edit ' . $object_description;
            return Mage::helper($groupname)->__($header_text);
        }

        $header_text = 'Add New ' . $object_description;
        return Mage::helper($groupname)->__($header_text);
    }
}
