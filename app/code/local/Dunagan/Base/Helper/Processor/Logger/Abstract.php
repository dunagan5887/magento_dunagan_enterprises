<?php
/**
 * Author: Sean Dunagan
 * Created: 4/11/15
 *
 * class Dunagan_Base_Helper_Processor_Logger_Abstract
 */

abstract class Dunagan_Base_Helper_Processor_Logger_Abstract
    extends Dunagan_Base_Model_Delegate_Abstract
    implements Dunagan_Base_Model_Delegate_Interface
{
    protected $_current_compilation_log_result = '';

    public function decorateSuccessMessage($notice_message)
    {
        return $notice_message;
    }

    public function decorateNoticeMessage($notice_message)
    {
        return $notice_message;
    }

    public function decorateErrorMessage($error_message)
    {
        return $error_message;
    }

    public function flushLogs()
    {
        return;
    }

    public function getCurrentLogData()
    {
        return $this->_current_compilation_log_result;
    }

    protected function _addDataToCurrentLogString($data_to_add)
    {
        $line_separator = $this->getLineSeparator();
        $this->_current_compilation_log_result .= $data_to_add . $line_separator;
    }

    protected function _initializeCurrentLogString()
    {
        $this->_current_compilation_log_result = '';
    }

    public function getLineSeparator()
    {
        return "\n";
    }
}
