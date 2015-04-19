<?php

/**
 * Author: Sean Dunagan
 * Created: 4/11/15
 *
 * Class Worldview_Feed_ProcessController
 */

class Worldview_Feed_ProcessController extends Mage_Adminhtml_Controller_Action
{
    const EXCEPTION_EXECUTING_PROCESS = 'An uncaught exception occurred when attempting to process article retrieval in method %s::%s : %s';

    // TODO implement acl for this controller
    public function articleRetrievalAction()
    {
        try
        {
            // Need to make modifications to be able to get log data in html, not text
            $helper = Mage::helper('worldview_feed/article_retrieval_processor');
            $process_log_data_objects_array = $helper->executeProcesses();

            $log_html_string = '';

            foreach($process_log_data_objects_array as $processLogData)
            {
                $log_html_string .= $processLogData->getCurrentLogData();
            }

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__($log_html_string));
        }
        catch(Exception $e)
        {
            $error_message = sprintf(self::EXCEPTION_EXECUTING_PROCESS, __CLASS__, __METHOD__, $e->getMessage());
            Mage::log($error_message);
            $exceptionToLog = new Exception($error_message);
            Mage::logException($exceptionToLog);
            Mage::getSingleton('adminhtml/session')->addError($this->__($error_message));
        }

        // Redirect to the articles grid page
        return $this->_redirect('worldview_article/index/index');
    }
}
