<?php

abstract class Dunagan_Io_Model_Export_File_Abstract
    extends Dunagan_Io_Model_Process_Abstract
    implements Dunagan_Io_Model_Export_File_Interface
{
    const FILE_PERMISSIONS      = 0777;

    const ERR_FILE_LOCK         = 'Error obtaining lock for file %s';
    const ERR_FILE_WRITE        = 'Error writing to file %s';

    protected $_error_log_file = 'io_export_error';
    protected $_transaction_filename_prefix = 'export_file';
    protected $_transaction_file_extension = '.txt';
    protected $_export_file_should_be_timestamped = false;

    abstract public function getExportDirectory();

    public function createFile($export_filename = null)
    {
        $ioAdapter = $this->_getIoAdapter();
        $ioAdapter->setAllowCreateFolders(true);
        $dirPath = $this->getExportDirectory();
        $ioAdapter->open(array('path' => $dirPath));

        if (is_null($export_filename))
        {
            $export_filename = ($this->_export_file_should_be_timestamped)
                                    ? $this->getTimestampedTransactionFileName()
                                    : $this->getTransactionFileName();
        }

        $filePath = $dirPath . DS . $export_filename;
        $ioAdapter->streamOpen($filePath, 'w+', self::FILE_PERMISSIONS);
        if(!$ioAdapter->streamLock(true))
        {
            throw new Dunagan_Io_Model_Exception(sprintf(self::ERR_FILE_LOCK, $filePath));
        }

        return true;
    }

    protected function _writeToFile($data_string)
    {
        $ioAdapter = $this->_getIoAdapter();
        if(!$ioAdapter->streamWrite($data_string))
        {
            $export_filename = $this->getExportFilename();
            throw new Dunagan_Io_Model_Exception(sprintf(self::ERR_FILE_WRITE, $export_filename));
        }

        return true;
    }

    public function closeFile()
    {
        $ioAdapter = $this->_getIoAdapter();
        $ioAdapter->streamUnlock();
        $ioAdapter->streamClose();
        return true;
    }
}
