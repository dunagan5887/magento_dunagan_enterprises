<?php
/**
 * Author: Sean Dunagan
 * Created: 4/11/15
 */

interface Dunagan_Base_Helper_Processor_Logger_Interface
    extends Dunagan_Base_Model_Delegate_Interface
{
    // OPTIONAL

    // The following fields may optionally be overridden by subclasses of Dunagan_Base_Helper_Processor_Logger_Abstract

    // MUST document these
    public function getCurrentLogData();

    public function decorateSuccessMessage($notice_message);

    public function decorateNoticeMessage($notice_message);

    public function decorateErrorMessage($error_message);

    public function getLineSeparator();

    public function flushLogs();
}