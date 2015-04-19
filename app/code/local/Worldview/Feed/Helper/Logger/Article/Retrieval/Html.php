<?php
/**
 * Author: Sean Dunagan
 * Created: 4/11/15
 *
 * class Worldview_Feed_Helper_Logger_Article_Retrieval_Html
 */

class Worldview_Feed_Helper_Logger_Article_Retrieval_Html
    extends Worldview_Feed_Helper_Logger_Article_Retrieval_Abstract
    implements Worldview_Feed_Helper_Logger_Article_Retrieval_Interface
{
    protected $_htmlDecorator = null;

    public function decorateSuccessMessage($success_message)
    {
        return empty($success_message)
                    ? $success_message
                    : $this->_getHtmlDecorator()->decorateSuccess($success_message);
    }

    public function decorateNoticeMessage($notice_message)
    {
        return $this->_getHtmlDecorator()->decorateNotice($notice_message);
    }

    public function decorateErrorMessage($error_message)
    {
        return $this->_getHtmlDecorator()->decorateError($error_message);
    }

    public function getLineSeparator()
    {
        return "<br>";
    }

    protected function _getHtmlDecorator()
    {
        if (is_null($this->_htmlDecorator))
        {
            $this->_htmlDecorator = Mage::helper('dunagan_base/decorator_html');
        }
    
        return $this->_htmlDecorator;
    }
}
