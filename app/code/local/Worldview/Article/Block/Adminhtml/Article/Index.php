<?php
/**
 * Author: Sean Dunagan
 * Created: 4/6/15
 * Class Worldview_Article_Block_Adminhtml_Source_Container
 */

class Worldview_Article_Block_Adminhtml_Article_Index
    extends Dunagan_Base_Block_Adminhtml_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        // Articles should only be added to the system via the feed retrieval process
        $this->_removeButton('add');
    }

    public function getActionButtonsToRender()
    {
        $article_retrieval_process_button = array(
            'action_url' => Mage::getModel('adminhtml/url')->getUrl('worldview_feed/process/articleRetrieval'),
            'label' => 'Retrieve Articles From Feed'
        );

        return array('article_retrieval' => $article_retrieval_process_button);
    }
}
