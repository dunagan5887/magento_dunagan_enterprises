<?php
/**
 * Author: Sean Dunagan
 * Created: 04/06/2015
 *
 * Class Worldview_Base_Controller_Adminhtml_Abstract
 */

abstract class Dunagan_Base_Controller_Adminhtml_Abstract
    extends Mage_Adminhtml_Controller_Action
    implements Dunagan_Base_Controller_Adminhtml_Interface
{
    // Documentation for these abstract classes is given in Dunagan_Base_Controller_Adminhtml_Interface
    abstract public function getModuleGroupname();

    abstract public function getControllerActiveMenuPath();

    abstract public function getModuleInstanceDescription();

    abstract public function getIndexBlockName();

    // The following is accessible via accessor method getModuleHelper()
    protected $_moduleHelper = null;

    public function indexAction()
    {
        $module_groupname = $this->getModuleGroupname();
        $module_description = $this->getModuleInstanceDescription();
        $module_block_classname = $module_groupname . '/' . $this->getIndexBlockName();

        $this->loadLayout()
            ->_setActiveMenuValue()
            ->_setSetupTitle(Mage::helper($module_groupname)->__($module_description))
            ->_addBreadcrumb()
            ->_addBreadcrumb(Mage::helper($module_groupname)->__($module_description), Mage::helper($module_groupname)->__($module_description))
            ->_addContent($this->getLayout()->createBlock($module_block_classname))
            ->renderLayout();
    }

    protected function _setSetupTitle($title)
    {
        try
        {
            $this->_title($title);
        }
        catch (Exception $e)
        {
            Mage::logException($e);
        }
        return $this;
    }

    protected function _addBreadcrumb($label = null, $title = null, $link=null)
    {
        $module_groupname = $this->getModuleGroupname();
        $module_description = $this->getModuleInstanceDescription();

        if (is_null($label))
        {
            $label = Mage::helper($module_groupname)->__($module_description);
        }
        if (is_null($title))
        {
            $title = Mage::helper($module_groupname)->__($module_description);
        }
        return parent::_addBreadcrumb($label, $title, $link);
    }

    protected function _setActiveMenuValue()
    {
        return parent::_setActiveMenu($this->getControllerActiveMenuPath());
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')
                    ->isAllowed($this->getControllerActiveMenuPath());
    }

    public function getModuleHelper()
    {
        if (is_null($this->_moduleHelper))
        {
            $module_groupname = $this->getModuleGroupname();
            $this->_moduleHelper = Mage::helper($module_groupname);
        }

        return $this->_moduleHelper;
    }
}
