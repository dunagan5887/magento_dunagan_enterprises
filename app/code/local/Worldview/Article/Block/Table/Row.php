<?php

/**
 * Author: Sean Dunagan (github: dunagan5887)
 * Date: 8/9/16
 */
class Worldview_Article_Block_Table_Row extends Mage_Core_Block_Template
{
    protected $_articleToDisplay = null;

    /**
     * @return Worldview_Article_Model_Article
     */
    public function getArticleToDisplay()
    {
        return $this->_articleToDisplay;
    }

    /**
     * @param Worldview_Article_Model_Article $articleToDisplay
     * @return $this
     */
    public function setArticleToDisplay(Worldview_Article_Model_Article $articleToDisplay)
    {
        $this->_articleToDisplay = $articleToDisplay;
        return $this;
    }
}
