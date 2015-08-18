<?php

abstract class Dunagan_Io_Model_Export_File_Csv extends Dunagan_Io_Model_Export_File_Abstract
{
    const ERROR_HEADER_ROW_ALREADY_SET = 'Header row was already set in file %s. Header will not be set again.';

    protected $_file_delimiter  = ',';
    protected $_file_enclosure  = '"';
    protected $_file_escape     = '\\';
    protected $_transaction_file_extension = '.csv';

    protected $_header_columns = array();
    protected $_is_header_set = false;
    protected $_csvHelper = null;

    public function addRowToFile(array $row)
    {
        $row_as_array = (is_object($row)) ? $row->getData() : $row;
        $row_as_string = $this->convertArrayToCsvContent($row_as_array, $this->_file_delimiter, $this->_file_enclosure, $this->_file_escape);
        $row_as_string .= "\n";
        return parent::_writeToFile($row_as_string);
    }

    public function convertArrayToCsvContent($data_array, $delimiter = ',', $enclosure = '"', $escape_char = '\\')
    {
        return $this->geCsvHelper()->buildCsvFileLine($data_array, $delimiter, $enclosure, $escape_char);
    }

    public function setHeaderRow(array $header_row)
    {
        if(!$this->_is_header_set)
        {
            $this->_header_columns = $header_row;
            $this->addRowToFile($header_row);
            $this->_is_header_set = true;
        }
        else
        {
            $error_message = sprintf(self::ERROR_HEADER_ROW_ALREADY_SET, $this->_export_file);
            $this->logError($error_message);
            return false;
        }

        return true;
    }

    public function resetHeaderRow(array $header_row)
    {
        $this->_is_header_set = false;
        $this->_header_columns = array();

        return $this->setHeaderRow($header_row);
    }

    public function getHeaderRow()
    {
        return $this->_header_columns;
    }

    public function geCsvHelper()
    {
        if (is_null($this->_csvHelper))
        {
            $this->_csvHelper = Mage::helper('dunagan_io/csv');
        }

        return $this->_csvHelper;
    }

    public function setFileDelimiter($file_delimiter)
    {
        $this->_file_delimiter = $file_delimiter;
    }

    public function setFileEnclosure($file_enclosure)
    {
        $this->_file_enclosure = $file_enclosure;
    }
}
