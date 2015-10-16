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

    abstract public function getModuleInstance();

    abstract public function getIndexActionsController();

    abstract public function getObjectParamName();

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
            ->loadBlocksBeforeGrid()
            ->_addContent($this->getLayout()->createBlock($module_block_classname))
            ->loadBlocksAfterGrid()
            ->renderLayout();
    }

    /**
     * This also can be done (and probably should be) via layout.xml
     *
        <ACTION_HANDLE>
            <block type="core/text_list" name="root" output="toHtml">
                <block type="BLOCK_CLASSNAME" name="BLOCK_LAYOUT_NAME"/>
            </block>
        </ACTION_HANDLE>
     *
     */
    public function ajaxGridAction()
    {
        $this->loadLayout();

        $rootBlock = $this->getLayout()->createBlock('core/text_list', 'root', array('output' => "toHtml"));
        $grid_block_classname = $this->getModuleGroupname() . '/' . $this->getIndexBlockName() . '_grid';
        $gridBlock = $this->getLayout()->createBlock($grid_block_classname, 'ajax.grid');
        $rootBlock->append($gridBlock, 'ajax.grid');

        $this->renderLayout();
    }

    /**
     * Returns the uri path for whatever controller action is passed in
     *
     * @param $action
     * @return string
     */
    public function getUriPathForIndexAction($action)
    {
        $uri_path = sprintf('%s/%s/%s', $this->getModuleRouterFrontname(), $this->getIndexActionsController(), $action);
        return $uri_path;
    }

    public function getObjectClassname()
    {
        $objects_module_instance = $this->getModuleInstance();
        $objects_module = $this->getModuleGroupname();
        $object_classname = $objects_module . '/' . $objects_module_instance;

        return $object_classname;
    }

    public function getModuleRouterFrontname()
    {
        return $this->getModuleGroupname();
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
        if(!Mage::getSingleton('admin/session')->isAllowed($this->getAclPath()))
        {
            return false;
        }

        return true;
    }

    public function loadBlocksBeforeGrid()
    {
        return $this;
    }

    public function loadBlocksAfterGrid()
    {
        return $this;
    }

    public function getCompleteClassnameBySuffix($classname_suffix)
    {
        return $this->getModuleGroupname() . '/' . $classname_suffix;
    }

    public function getAclPath()
    {
        return $this->getControllerActiveMenuPath();
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
