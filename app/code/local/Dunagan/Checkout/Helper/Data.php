<?php
/**
 * Author: Sean Dunagan
 * Created: 4/15/15
 *
 * class Dunagan_Checkout_Helper_Data
 */

class Dunagan_Checkout_Helper_Data extends Mage_Checkout_Helper_Data
{
    public function getCartUrl()
    {
        return Mage::helper('checkout/url')->getCartUrl();
    }

    public function getTopLinksCheckoutUrl()
    {
        return Mage::helper('dunagan_checkout/url')->getTopLinksCheckoutUrl();
    }

    public function getCheckoutUrl()
    {
        return Mage::helper('checkout/url')->getCheckoutUrl();
    }
}
