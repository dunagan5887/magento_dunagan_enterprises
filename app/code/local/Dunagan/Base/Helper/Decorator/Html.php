<?php
/**
 * Author: Sean Dunagan
 * Created: 4/11/15
 *
 * class Dunagan_Base_Helper_Decorator_Html
 */

class Dunagan_Base_Helper_Decorator_Html
{
    const SUCCESS_MESSAGE_TEMPLATE = '<span style="color:green"><b>%s</b></span>';
    const NOTICE_MESSAGE_TEMPLATE = '<span style="color:blue"><b>%s</b></span>';
    const ERROR_MESSAGE_TEMPLATE = '<span style="color:red"><b>%s</b></span>';

    public function decorateSuccess($success_message)
    {
        return sprintf(self::SUCCESS_MESSAGE_TEMPLATE, $success_message);
    }

    public function decorateNotice($notice_message)
    {
        return sprintf(self::NOTICE_MESSAGE_TEMPLATE, $notice_message);
    }

    public function decorateError($error_message)
    {
        return sprintf(self::ERROR_MESSAGE_TEMPLATE, $error_message);
    }
}
