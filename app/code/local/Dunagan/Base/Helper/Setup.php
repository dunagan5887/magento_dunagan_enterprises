<?php
/**
 * Author: Sean Dunagan
 * Created: 6/25/15
 *
 * class Dunagan_Base_Helper_Setup
 */

class Dunagan_Base_Helper_Setup
{
    protected $_resourceSetup = null;

    public function getCatalogEavSetupModel()
    {
        $catalogEavSetupModel = Mage::getModel('catalog/resource_eav_mysql4_setup', 'core_setup');
        return $catalogEavSetupModel;
    }

    public function getWriteAdapter()
    {
        $write_connection = Mage::getModel('core/resource')->getConnection('core_write');
        return $write_connection;
    }

    public function removeAttributeSetIfExists($eav_setup, $entity_type_id, $attribute_set_name)
    {
        $attribute_set = $eav_setup->getAttributeSet($entity_type_id, $attribute_set_name, 'attribute_set_name');
        if ($attribute_set)
        {
            $eav_setup->removeAttributeSet($entity_type_id, $attribute_set_name);
        }

        return $this;
    }

    public function addAttributeSet($eav_setup, $entity_type_code, $attribute_set_name)
    {
        $entity_type_id = $eav_setup->getEntityTypeId($entity_type_code);
        $default_attribute_set_id = $eav_setup->getAttributeSetId($entity_type_id, 'default');

        $new_attribute_set  = Mage::getModel('eav/entity_attribute_set')
                                ->setEntityTypeId($entity_type_id);
        $new_attribute_set->setAttributeSetName($attribute_set_name);
        $new_attribute_set->validate();
        $new_attribute_set->save();
        $new_attribute_set->initFromSkeleton($default_attribute_set_id);
        $new_attribute_set->save();

        return $new_attribute_set->getId();
    }

    public function addProductAttributeGroupToAttributeSet($eav_setup, $attribute_set_id, $group_name, $sort_order = null)
    {
        $entity_type_id = $eav_setup->getEntityTypeId('catalog_product');
        $eav_setup->addAttributeGroup($entity_type_id, $attribute_set_id, $group_name, $sort_order);
        $attribute_group_id = $eav_setup->getAttributeGroupId($entity_type_id, $attribute_set_id, $group_name);
        return $attribute_group_id;
    }

    public function addCategoryAttributeGroupToAttributeSet($eav_setup, $attribute_set_id, $group_name, $sort_order = null)
    {
        $entity_type_id = $eav_setup->getEntityTypeId('catalog_category');
        $eav_setup->addAttributeGroup($entity_type_id, $attribute_set_id, $group_name, $sort_order);
        $attribute_group_id = $eav_setup->getAttributeGroupId($entity_type_id, $attribute_set_id, $group_name);
        return $attribute_group_id;
    }

    public function removeAttributeGroupIfExists($eav_setup, $entity_type_id, $attribute_set_id, $attribute_group_name)
    {
        $default_attribute_group_id = $eav_setup->getAttributeGroupId($entity_type_id, $attribute_set_id, 'General');
        $attribute_group_id = $eav_setup->getAttributeGroupId($entity_type_id, $attribute_set_id, $attribute_group_name);
        if ($default_attribute_group_id != $attribute_group_id)
        {
            $eav_setup->removeAttributeGroup($entity_type_id, $attribute_set_id, $attribute_group_name);
        }

        return $this;
    }

    public function getResourceSetup()
    {
        if (is_null($this->_resourceSetup))
        {
            $this->_resourceSetup = Mage::getModel('core/resource_setup', 'core_setup');
        }

        return $this->_resourceSetup;
    }
}
