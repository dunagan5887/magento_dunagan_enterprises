<?php
/**
 * Author: Sean Dunagan
 * Created: 6/24/15
 */

class Dunagan_Base_Helper_Hierarchy_Parent_Id
{
    const ROOT_ID = 'root';

    protected $_parent_id_to_children_ids_mapping = array();

    public function getRootIds()
    {
        return isset($this->_parent_id_to_children_ids_mapping[self::ROOT_ID])
                ? $this->_parent_id_to_children_ids_mapping[self::ROOT_ID]
                : array();
    }

    public function getChildrenOfParentById($parent_id)
    {
        return isset($this->_parent_id_to_children_ids_mapping[$parent_id])
                    ? $this->_parent_id_to_children_ids_mapping[$parent_id]
                    : array();
    }

    public function setParentOfChild($child_id, $parent_id)
    {
        if (is_null($parent_id) || (!strcmp($parent_id, '')))
        {
            $parent_id = self::ROOT_ID;
        }

        if (!isset($this->_parent_id_to_children_ids_mapping[$parent_id]))
        {
            $this->_parent_id_to_children_ids_mapping[$parent_id] = array();
        }

        $this->_parent_id_to_children_ids_mapping[$parent_id][$child_id] = $child_id;
    }
}
