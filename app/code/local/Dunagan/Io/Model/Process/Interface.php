<?php
/**
 * Author: Sean Dunagan
 * Created: 6/3/15
 */

interface Dunagan_Io_Model_Process_Interface
{
    // The following methods are OPTIONAL to override for subclasses of abstract class Dunagan_Io_Model_Process_Abstract
    /**
     * Directory to import files from or export files to
     *
     * @return string - Default: Mage::getBaseDir('var');
     */
    public function getTransactionDirectory();

    // The following instance fields are OPTIONAL to be defined by subclasses of abstract class Dunagan_Io_Model_Process_Abstract
    /*
     * The following two instance fields determine the name of the file which will log all errors/messages for the process
        protected $_error_log_file = 'io_process_error';
        protected $_error_log_file_extension = '.log';
     * The following fields determine the name of the file which will be produced by a call to
     *      Dunagan_Io_Model_Process_Abstract::getTransactionFileName() or
     *      Dunagan_Io_Model_Process_Abstract::getTimestampedTransactionFileName()
        protected $_transaction_file_extension = '.txt';
        protected $_transaction_filename_prefix = 'transaction_file';
     * The following fields determine the name of the file which will be produced by a call to
     *      Dunagan_Io_Model_Process_Abstract::getTimestampedTransactionFileName()
        protected $_timestamp_php_date_format = 'Ymd_His';
     *
     */
}
