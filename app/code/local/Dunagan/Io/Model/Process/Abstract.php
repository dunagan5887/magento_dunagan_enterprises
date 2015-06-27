<?php
/**
 * Author: Sean Dunagan
 * Created: 6/3/15
 */

abstract class Dunagan_Io_Model_Process_Abstract
    extends Varien_Object
    implements Dunagan_Io_Model_Process_Interface
{
    protected $_error_log_file = 'io_process_error';
    protected $_error_log_file_extension = '.log';
    protected $_timestamp_php_date_format = 'Ymd_His';
    protected $_transaction_file_extension = '.txt';
    protected $_transaction_filename_prefix = 'transaction_file';

    protected function _getIoAdapter()
    {
        if (!$this->hasData('io_adapter'))
        {
            $ioAdapter = Mage::getModel('dunagan_io/io_file');
            $ioAdapter->setAllowCreateFolders(true);
            $this->setData('io_adapter', $ioAdapter);
        }

        return $this->getData('io_adapter');
    }

    public function getTransactionDirectory()
    {
        return Mage::getBaseDir('var');
    }

    public function logError($message)
    {
        $filename = $this->_error_log_file . $this->_error_log_file_extension;

        Mage::log($message, Zend_Log::ERR, $filename);

        return $this;
    }

    public function logMessage($message, $message_level = null)
    {
        $filename = $this->_error_log_file . $this->_error_log_file_extension;

        $message_level = is_null($message_level) ? Zend_Log::INFO : $message_level;

        Mage::log($message, $message_level, $filename);

        return $this;
    }

    public function getTransactionFileName($file_prefix = null)
    {
        $file_prefix = is_null($file_prefix) ? $this->_transaction_filename_prefix : $file_prefix;
        return $file_prefix . $this->_transaction_file_extension;
    }

    public function getTimestampedTransactionFileName($file_prefix = null)
    {
        $file_prefix = is_null($file_prefix) ? $this->_transaction_filename_prefix : $file_prefix;
        return $file_prefix . '_' . $this->getFileNameTimestamp() . $this->_transaction_file_extension;
    }

    public function getFileNameTimestamp()
    {
        return Mage::getModel('core/date')->date($this->_timestamp_php_date_format);
    }
}