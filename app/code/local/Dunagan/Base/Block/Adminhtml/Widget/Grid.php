<?php

/**
 * Author: Sean Dunagan
 * Created: 04/06/2015
 *
 * Class Worldview_Base_Block_Adminhtml_Widget_Grid
 *
 * This class expects the controller to a descendant of class Worldview_Base_Controller_Adminhtml_Abstract
 */

class Dunagan_Base_Block_Adminhtml_Widget_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_translationHelper = null;

    public function __construct()
    {
        parent::__construct();
        $controllerAction = $this->getAction();
        $grid_path = str_replace('/', '_', $controllerAction->getControllerActiveMenuPath());
        $grid_id = $controllerAction->getModuleGroupname() . '_' . $grid_path;

        $this->setId($grid_id);
        $this->setUseAjax(false);
        $this->setSaveParametersInSession(true);
    }

    protected function _getTranslationHelper()
    {
        if (is_null($this->_translationHelper))
        {
            $controllerAction = $this->getAction();
            $this->_translationHelper = $controllerAction->getModuleHelper();
        }

        return $this->_translationHelper;
    }
}
