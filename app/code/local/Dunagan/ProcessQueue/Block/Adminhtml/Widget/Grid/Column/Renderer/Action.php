<?php
/**
 * Author: Sean Dunagan
 * Created: 9/16/15
 */
class Dunagan_ProcessQueue_Block_Adminhtml_Widget_Grid_Column_Renderer_Action
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    const CONFIRM_TEMPLATE = 'Are you sure you want to manually %s this order sync task?';

    public function render(Varien_Object $row)
    {
        $task_action_text = $row->getActionText();
        if (empty($task_action_text))
        {
            return '';
        }

        $action_array = array();
        $action_array['caption'] = $task_action_text;
        $action_array['confirm'] = sprintf(self::CONFIRM_TEMPLATE, $task_action_text);

        $action_url = $this->getAction()->getUriPathForIndexAction('actOnTask');
        $param_name = $this->getAction()->getObjectParamName();
        $action_url = $this->getUrl($action_url, array($param_name => $row->getId()));
        $action_array['url'] = $action_url;

        return $this->_toLinkHtml($action_array, $row);
    }
}
