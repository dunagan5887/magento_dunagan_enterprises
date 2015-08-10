<?php

class DLS_Utility_Helper_Url
{
    protected $_special_url_characters =
        array('.', ' ', '$', '&', '`', ':', '<', '>', '[', ']', '{', '}', '"', '+', '#', '%', '@', '/', ';', '=', '?', '\\', '^', '|', '~', '\'', ',');

    public function createUrlRewrite($config_data)
    {
        $url_rewrite = Mage::getModel('core/url_rewrite');
        Mage::helper('core/url_rewrite')->validateRequestPath($config_data['request_path']);
        $url_rewrite->setData($config_data);

        return $url_rewrite;
    }

    public function createUrlSafeString($unescaped_string)
    {
        $escaped_string = str_replace($this->_special_url_characters, '_', $unescaped_string);
        $escaped_string = str_replace('_', '-', $escaped_string);
        $url_safe_string = strtolower($escaped_string);

        return $url_safe_string;
    }

    public function getSpecialUrlCharacters()
    {
        return $this->_special_url_characters;
    }
}
