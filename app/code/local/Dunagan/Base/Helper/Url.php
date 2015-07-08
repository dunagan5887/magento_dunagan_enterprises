<?php
/**
 * Author: Sean Dunagan
 * Created: 6/25/15
 */

class Dunagan_Base_Helper_Url
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
        $escaped_string = preg_replace('/[^A-Za-z0-9-]/', '-', $unescaped_string);
        // url keys can only have 1 consecutive hyphen. Need to remove all consecutive hyphens
        $escaped_string = preg_replace('/[-]{2,}/', '-', $escaped_string);
        // url keys should not start or end with a hyphen
        $escaped_string = preg_replace('/^-/', '', $escaped_string);
        $escaped_string = preg_replace('/-$/', '', $escaped_string);

        $url_safe_string = strtolower($escaped_string);

        return $url_safe_string;
    }

    public function getSpecialUrlCharacters()
    {
        return $this->_special_url_characters;
    }
}
