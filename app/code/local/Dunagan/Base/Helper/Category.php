<?php

class Dunagan_Base_Helper_Category
{
    const ERROR_INVALID_CATEGORY_ID = 'No category with entity_id %s was able to be loaded.';
    const ERROR_OCCURRED_WHILE_ADDING_PRODUCTS_TO_CATEGORY = 'An exception was thrown while adding products to category %s: %s';

    const ADMIN_STORE_ID = 0;

    protected $_storeRootCategories = null;
    protected $_store_root_category_paths = null;
    protected $_urlHelper = null;
    protected $_category_image_media_folder = null;
    protected $_category_hierarchy_mapping = array();

    /**
     * Will create a category given the data passed in
     * @param Varien_Object|array   $categoryData
     * $categoryData should contain the following fields:
     *      'name'                          REQUIRED
     *      'description'                   OPTIONAL Default = name field value
     *      'url_key'                       OPTIONAL             - The url key. Default will be the category page_title value, escaped
     *                                                              to ensure that no special html characters are included
     *      'path'                          OPTIONAL Default - Will default to being a child of the root category for the store which
     *                                                          was specified by parameter $store_id. If store_id is null, will be the
     *                                                          default store
     *      'meta_title'                    OPTIONAL Default - Will default to the name field value
     *      'meta_description'              OPTIONAL Default - Will default to the description field value
     *      'meta_keywords'                 OPTIONAL Default - Will default to the name field value
     *      'is_active'                     OPTIONAL Default = 1 - Whether category should be active
     *      'image_filename'                OPTIONAL Default = false - The image to be used as the category image
     *                                                                  The image MUST exist in the {root}/media/catalog/category
     *                                                                  directory in order to be used
     *      'include_in_menu'               OPTIONAL Default = 1 - Whether category should be included in the navigation menu
     *      'custom_use_parent_settings'    OPTIONAL Default = 1 - Whether category should inherit all of parent category's settings
     *      'custom_apply_to_products'      OPTIONAL Default = 0 - Whether custom settings should be applied to all product assigned
     *                                                              to this category, if 0 then customization is only reflected on
     *                                                              the categories page
     *      'custom_design'                 OPTIONAL Default = 0 - The custom design for the category listing page, if one exists
     *      'page_layout'                   OPTIONAL Default = 0 - The custom page layout for the category listing page, if one exists
     *      'is_anchor'                     OPTIONAL Default = 1 - If a category is an anchor category, its sub-categories will be
     *                                                              displayed as layered navigation options
     *      'display_mode'                  OPTIONAL Default = 'PRODUCTS'
     *                                                              'PRODUCTS'          - Display Products only
     *                                                              'PAGE'              - Static block only
     *                                                              'PRODUCTS_AND_PAGE' - Static block and products
     *      'landing_page'                  OPTIONAL Default = '' = The CMS Block ID of the CMS Block to be displayed on the
     *                                                               category listing page, if one should exist.
     *      'available_sort_by'             OPTIONAL Default = array() = The list of product attributes that the category
     *                                                                      should be allowed to sort products by
     *                                                                      on the category product listing page
     *      'default_sort_by'               OPTIONAL Default = false   The product attribute that products should be sorted by
     *                                                                  on the category product listing page
     *
     * @param int                   $store_id - The id of the store to import to
     * @return false|Mage_Core_Model_Abstract
     */
    public function createCategoryObject($categoryData, $store_id = null)
    {
        if (is_object($categoryData))
        {
            $categoryData = $categoryData->getData();
        }
        if (!is_array($categoryData) || !isset($categoryData['name']))
        {
            return false;
        }

        if(is_null($store_id))
        {
            $store_id = self::ADMIN_STORE_ID;
        }

        $category_object = Mage::getModel('catalog/category');

        $category_object->setStoreId($store_id);
        $category_object->setName($categoryData['name']);
        $description = isset($categoryData['description']) ? $categoryData['description'] : $categoryData['name'];
        $category_object->setDescription($description);

        $is_active = isset($categoryData['is_active']) ? $categoryData['is_active'] : 1;
        $category_object->setIsActive($is_active);

        $meta_title = isset($categoryData['meta_title']) ? $categoryData['meta_title'] : $categoryData['name'];
        $category_object->setData('meta_title', $meta_title);
        $meta_description = isset($categoryData['meta_description']) ? $categoryData['meta_description'] : $description;
        $category_object->setData('meta_description', $meta_description);
        $meta_keywords = isset($categoryData['meta_keywords']) ? $categoryData['meta_keywords'] : $categoryData['name'];
        $category_object->setData('meta_keywords', $meta_keywords);

        $url_key = (isset($categoryData['url_key']))
                        ? $categoryData['url_key']
                        : $this->_getUrlHelper()->createUrlSafeString($meta_title);
        $category_object->setUrlKey($url_key);

        $include_in_menu = isset($categoryData['include_in_menu']) ? $categoryData['include_in_menu'] : 1;
        $category_object->setIncludeInMenu($include_in_menu);
        $custom_use_parent_settings = isset($categoryData['custom_use_parent_settings']) ? $categoryData['custom_use_parent_settings'] : 1;
        $category_object->setData('custom_use_parent_settings', $custom_use_parent_settings);
        $custom_apply_to_products = isset($categoryData['custom_apply_to_products']) ? $categoryData['custom_apply_to_products'] : 0;
        $category_object->setData('custom_apply_to_products', $custom_apply_to_products);
        $custom_design = isset($categoryData['custom_design']) ? $categoryData['custom_design'] : '';
        $category_object->setData('custom_design', $custom_design);
        $page_layout = isset($categoryData['page_layout']) ? $categoryData['page_layout'] : '';
        $category_object->setData('page_layout', $page_layout);
        $is_anchor = isset($categoryData['is_anchor']) ? $categoryData['is_anchor'] : 1;
        $category_object->setData('is_anchor', $is_anchor);
        $display_mode = isset($categoryData['display_mode']) ? $categoryData['display_mode'] : 'PRODUCTS';
        $category_object->setData('display_mode', $display_mode);
        $landing_page_cms_block = isset($categoryData['landing_page']) ? $categoryData['landing_page'] : '';
        $category_object->setData('landing_page', $landing_page_cms_block);
        // For now, only default category attribute sets are implemented for this method
        $category_object->setAttributeSetId($category_object->getDefaultAttributeSetId());

        $image_filename = isset($categoryData['image_filename']) ? $categoryData['image_filename'] : false;
        $category_object->setImage($image_filename);

        $category_path = isset($categoryData['path']) ? $categoryData['path'] : $this->getStoreRootCategoryPath($store_id);
        $category_object->setPath($category_path);

        $available_sort_by = isset($categoryData['available_sort_by']) ? $categoryData['available_sort_by'] : array();
        $category_object->setData('available_sort_by', $available_sort_by);

        $default_sort_by = isset($categoryData['default_sort_by']) ? $categoryData['default_sort_by'] : false;
        $category_object->setData('default_sort_by', $default_sort_by);

        return $category_object;
    }

    /**
     * Any products which were in the category but are not included in the $product_ids array will be removed
     * from the category via this functionality
     *
     * This method expects $product_ids to be an array of the following form:
     *      product_id_1 => category_position_1,
     *      product_id_2 => category_position_2,
     *      product_id_3 => category_position_3
     *
     * If no position is defined for the product, then category_position_n should be set to empty string ""
     *
     * @param $category_id
     * @param array $product_ids
     * @param null $store_id
     * @throws Exception
     */
    public function setProductsOnCategoryByProductIds($category_id, array $product_ids, $store_id = null)
    {
        $categoryObject = $this->_loadCategoryById($category_id, $store_id);
        $categoryObject->setPostedProducts($product_ids);

        try {
            $validate = $categoryObject->validate();
            if ($validate !== true) {
                foreach ($validate as $code => $error) {
                    if ($error === true) {
                        Mage::throwException(Mage::helper('catalog')->__('Attribute "%s" is required.', $categoryObject->getResource()->getAttribute($code)->getFrontend()->getLabel()));
                    }
                    else {
                        Mage::throwException($error);
                    }
                }
            }

            $categoryResource = Mage::getModel('dunagan_base/resource_category');
            $categoryResource->setCategoryProducts($categoryObject);
        }
        catch (Exception $e){
            $error_message = sprintf(self::ERROR_OCCURRED_WHILE_ADDING_PRODUCTS_TO_CATEGORY, $category_id, $e->getMessage());
            Mage::log($error_message);
            $exceptionToLog = new Exception($error_message);
            Mage::logException($exceptionToLog);
        }
    }

    /**
     *
     *
     * An array of this form is necessary to add products to a category
     *
     * @param $product_ids
     * @return array
     */
    protected function _convertProductsIdsToPostedProductsArray($product_ids)
    {
        $posted_product_ids_array = array();

        foreach ($product_ids as $product_id)
        {
            $posted_product_ids_array[$product_id] = "";
        }

        return $posted_product_ids_array;
    }

    protected function _loadCategoryById($category_id, $store_id = null)
    {
        $category = Mage::getModel('catalog/category');
        if (!is_null($store_id))
        {
            $category->setStoreId($store_id);
        }

        $category->load($category_id);

        if ((!is_object($category)) || (!$category->getId()))
        {
            if (!is_null($store_id))
            {
                $store_id_clause = 'and store id ' . $store_id . ' ';
            }
            else
            {
                $store_id_clause = '';
            }
            $error_message = sprintf(self::ERROR_INVALID_CATEGORY_ID, $category_id, $store_id_clause);
            Mage::log($error_message);
            $exceptionToLog = new Exception($error_message);
            throw $exceptionToLog;
        }

        return $category;
    }

    public function getStoreRootCategoryPath($store_id)
    {
        if (is_null($this->_store_root_category_paths))
        {
            $this->_store_root_category_paths = array();
        }

        if (!isset($this->_store_root_category_paths[$store_id]))
        {
            $storeRootCategory = $this->getStoreRootCategory($store_id);
            $this->_store_root_category_paths[$store_id] = $storeRootCategory->getPath();
        }

        return $this->_store_root_category_paths[$store_id];
    }

    public function getStoreRootCategory($store_id)
    {
        if (is_null($this->_storeRootCategories))
        {
            $this->_storeRootCategories = array();
        }

        if (!isset($this->_storeRootCategories[$store_id]))
        {
            $store = Mage::getModel('core/store')->load($store_id);
            $root_category_id = $store->getRootCategoryId();
            $this->_storeRootCategories[$store_id] = Mage::getModel('catalog/category')->load($root_category_id);
        }

        return $this->_storeRootCategories[$store_id];
    }



    public function getCategoryHierarchyByCategoryId($category_id)
    {
        if (!isset($this->_category_hierarchy_mapping[$category_id]))
        {
            $category = Mage::getModel('catalog/category')->load($category_id);
            $parent_categories = $category->getParentCategories();
            $category_hierarchy = array();

            foreach ($parent_categories as $parent_category)
            {
                $category_hierarchy[] = $parent_category->getName();
            }

            $this->_category_hierarchy_mapping[$category_id] = $category_hierarchy;
        }

        return $this->_category_hierarchy_mapping[$category_id];
    }

    protected function _getUrlHelper()
    {
        if (is_null($this->_urlHelper))
        {
            $this->_urlHelper = Mage::helper('dunagan_base/url');
        }

        return $this->_urlHelper;
    }
}
