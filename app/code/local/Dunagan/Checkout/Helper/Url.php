<?php
/**
 * Author: Sean Dunagan
 * Created: 4/15/15
 *
 * class Dunagan_Checkout_Helper_Url
 */

class Dunagan_Checkout_Helper_Url extends Mage_Checkout_Helper_Url
{
    public function getTopLinksCheckoutUrl()
    {
        return $this->_getUrl('checkout');
    }
}
