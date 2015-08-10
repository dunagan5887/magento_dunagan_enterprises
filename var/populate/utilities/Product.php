<?php


class DLS_Utility_Helper_Product
{
    protected $_default_filter_stock_data = null;

    public function createProductObject($product_data, $store_id)
    {
        $default_stock_data = $this->_getDefaultFilterStockData();
        $product_data['stock_data'] = $default_stock_data;

        $product = Mage::getModel('catalog/product');
        $product->setData('_edit_mode', true);

        $product->setStoreId($store_id);
        $product->addData($product_data);

        return $product;
    }

    protected function _getDefaultFilterStockData()
    {
        if (is_null($this->_default_filter_stock_data))
        {
            $this->_default_filter_stock_data = array(
                'use_config_manage_stock' => '1',
                'original_inventory_qty' => '0',
                'qty' => 10000,
                'use_config_min_qty' => '1',
                'use_config_min_sale_qty' => '1',
                'use_config_max_sale_qty' => '1',
                'is_qty_decimal' => '0',
                'is_decimal_divided' => 0,
                'use_config_backorders' => '1',
                'use_config_notify_stock_qty' => '1',
                'use_config_enable_qty_increments' => '1',
                'use_config_qty_increments' => '1',
                'is_in_stock' => '1',
            );
        }

        return $this->_default_filter_stock_data;
    }
}
