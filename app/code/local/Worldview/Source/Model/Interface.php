<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 6:33 PM
 */

interface Worldview_Source_Model_Interface
{
    /**
     * @return string - Represents the feed's unique identifier
     */
    public function getSourceCode();

    public function getArticleScraperModel();
}
