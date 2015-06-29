<?php

class DLS_URapidFlow_Helper_Profile_Manager_Product_Import
    extends Dunagan_URapidFlow_Helper_Profile_Manager
{
    protected function _getDefaultDataArray()
    {
        if (is_null($this->_default_data))
        {
            $default_attribute_set_id = 'Default';

            $default_data = parent::_getDefaultDataArray();
            $default_data['title'] = 'Product Import Template';
            $default_data['filename'] = 'product_import_template.csv';
            $default_data['options']['export'] = array('allow_mutable_attributes' => '');
            $default_data['options']['import'] = array(
                                                    'actions' => 'any',
                                                    'dryrun' => '0',
                                                    'change_typeset' => '0',
                                                    'select_ids' => '0',
                                                    'not_applicable' => '0',
                                                    'store_value_same_as_default' => 'default',
                                                    'stock_zero_out' => '0',
                                                    'increment_url_key' => '0',
                                                    'reindex_type' => 'full',
                                                    'image_files' => '0',
                                                    'image_files_remote' => '0',
                                                    'image_remote_subfolder_level' => '',
                                                    'image_delete_old' => '0',
                                                    'image_delete_skip_usage_check' => '0',
                                                    'image_missing_file' => 'warning_save',
                                                    'create_options' => '0',
                                                    'create_categories' => '0',
                                                    'create_categories_active' => '0',
                                                    'create_categories_anchor' => '0',
                                                    'create_categories_display' => 'PRODUCTS',
                                                    'create_categories_menu' => '0',
                                                    'delete_old_category_products' => '0',
                                                    'create_attributesets' => '0',
                                                    'create_attributeset_template' => $default_attribute_set_id,
                                                    'insert_attr_chunk_size' => ''
                                                );

            $default_data['json_export'] = '{"options":{"csv":{"delimiter":",","enclosure":"\"","escape":"\\","multivalue_separator":";"},"encoding":{"from":"UTF-8","to":"UTF-8"},"log":{"min_level":"SUCCESS"}}}';
            $this->_default_data = $default_data;
        }

        return $this->_default_data;
    }

    public function resetUrfProductImportResource()
    {
        $newResourceModel = Mage::getModel('urapidflow_mysql4/catalog_product', array());
        Mage::unregister('_singleton/urapidflow_mysql4/catalog_product');
        Mage::register('_singleton/urapidflow_mysql4/catalog_product', $newResourceModel);
    }
}
