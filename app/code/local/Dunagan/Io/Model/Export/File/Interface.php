<?php
/**
 * Author: Sean Dunagan
 * Created: 6/3/15
 */

interface Dunagan_Io_Model_Export_File_Interface extends Dunagan_Io_Model_Process_Interface
{
    // The following methods are REQUIRED for classes which implement this interface
    /**
     * The absolute directory to export files to
     *
     * @return string
     */
    public function getExportDirectory();

    // The following instance fields are OPTIONAL to define for subclasses of abstract class Dunagan_Io_Model_Export_File_Abstract
    /**
     * This field determines whether an error should be logged when a file with an invalid name is found in the import directory
            protected $_error_log_file = 'io_export_error';
            protected $_transaction_filename_prefix = 'export_file';
            protected $_transaction_file_extension = '.txt';
            protected $_export_file_should_be_timestamped = true;
     */
}
