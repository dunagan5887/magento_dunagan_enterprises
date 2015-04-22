<?php

/**
 * Author: Sean Dunagan
 * Created: 04/06/2015
 *
 * Class Worldview_Article_IndexController
 */

class Worldview_Article_IndexController
    extends Dunagan_Base_Controller_Adminhtml_Form_Abstract
    implements Dunagan_Base_Controller_Adminhtml_Form_Interface
{
    const ERROR_ARTICLE_CREATION_IN_ADMIN_PANEL = 'Articles can only be created via the feed process. They can not be created by hand in the admin panel.';

    // Implementing methods for Dunagan_Base_Controller_Adminhtml_Interface
    public function getModuleGroupname()
    {
        return 'worldview_article';
    }

    public function getControllerActiveMenuPath()
    {
        return 'worldview/articles/view_articles';
    }

    public function getModuleInstanceDescription()
    {
        return 'Articles';
    }

    public function getIndexBlockName()
    {
        return 'adminhtml_article_index';
    }

    // Implementing methods for Dunagan_Base_Controller_Adminhtml_Form_Interface
    public function validateDataAndCreateObject($objectToCreate, $posted_object_data)
    {
        throw new Dunagan_Base_Model_Adminhtml_Exception(self::ERROR_ARTICLE_CREATION_IN_ADMIN_PANEL);
    }

    public function validateDataAndUpdateObject($objectToUpdate, $posted_object_data)
    {
        // Since people doing code reviews of the site will have privileges to update the 'active' setting on a source,
        // do some data validation here
        $no_hacking_occurred = $this->_assertDataIsRestrictedToFields($posted_object_data, array('is_biased'));
        $no_required_fields_were_missing = $this->_assertRequiredFieldsAreIncluded($posted_object_data, array('is_biased'));
        $objectToUpdate->addData($posted_object_data);
        return $objectToUpdate;
    }

    public function getObjectParamName()
    {
        return 'article';
    }

    public function getObjectDescription()
    {
        return 'Article';
    }

    public function getModuleInstance()
    {
        return 'article';
    }
    public function getFormBlockName()
    {
        return 'adminhtml_article';
    }

    public function getFormActionsController()
    {
        return 'index';
    }
} 