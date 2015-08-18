<?php


class Dunagan_Base_Model_Resource_Category extends Mage_Catalog_Model_Resource_Category
{
    /**
     * This method expects that the product_ids will already have been set on the $categoryObject
     * Method Dunagan_Base_Helper_Category::setProductsOnCategoryByProductIds() will accomplish this
     *
     * @param $categoryObject
     */
    public function setCategoryProducts($categoryObject)
    {
        $this->_saveCategoryProducts($categoryObject);
    }
}
