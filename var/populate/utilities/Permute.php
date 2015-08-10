<?php

class DLS_Utility_Helper_Permute
{
    const PERMUTING_REGEX = '#(.*)%%PERMUTING_CHAR%%([0-9]+)$#';
    const PERMUTING_BASE_STRING_INDEX = 1;
    const PERMUTING_DIGIT_INDEX = 2;

    const DEFAULT_VALUE_TYPE = 'default';

    protected $_permuted_values = array();
    protected $_permuting_character = '-';
    protected $_permuting_regex = null;

    public function setPermutingCharacter($permuting_character)
    {
        $this->_permuting_character = $permuting_character;
        $this->_permuting_regex = str_replace('%%PERMUTING_CHAR%%', $this->_permuting_character, self::PERMUTING_REGEX);
        return $this;
    }

    public function getPermutedValue($value, $type = null)
    {
        if (is_null($type))
        {
            $type = self::DEFAULT_VALUE_TYPE;
        }

        if (!$this->_isValueAlreadyStored($value, $type))
        {
            $this->_storeValue($value, $type);
            return $value;
        }
        // Need to permute the value
        $permuted_value = $this->_permuteValue($value, $type);
        // Store the value
        $this->_storeValue($permuted_value, $type);
        // Return the new value
        return $permuted_value;
    }

    protected function _permuteValue($value, $type)
    {
        if (is_null($this->_permuting_regex))
        {
            $this->setPermutingCharacter($this->_permuting_character);
        }

        // Check if permuting character and digit have already been added to the string
        $matches = array();
        $permuting_digit_is_present = preg_match($this->_permuting_regex, $value, $matches);

        if ($permuting_digit_is_present)
        {
            $string_base = $matches[self::PERMUTING_BASE_STRING_INDEX];
            $permuting_digit = intval($matches[self::PERMUTING_DIGIT_INDEX]);
            $new_permuting_digit = $permuting_digit + 1;
            $new_permuted_string = $string_base . $this->_permuting_character . $new_permuting_digit;
            // See if the new permuted string has already been stored
            if ($this->_isValueAlreadyStored($new_permuted_string, $type))
            {
                // If so, permute again
                return $this->_permuteValue($new_permuted_string, $type);
            }
            // Otherwise return the new string
            return $new_permuted_string;
        }
        // The permuting character was not present; add it and check for existence
        $new_permuted_string = $value . $this->_permuting_character . 1;
        if ($this->_isValueAlreadyStored($new_permuted_string, $type))
        {
            // If so, permute again
            return $this->_permuteValue($new_permuted_string, $type);
        }
        // Otherwise return it
        return $new_permuted_string;
    }

    protected function _storeValue($value, $type)
    {
        $this->_permuted_values[$type][$value] = $value;
    }

    protected function _isValueAlreadyStored($value, $type)
    {
        if (!isset($this->_permuted_values[$type]))
        {
            $this->_permuted_values[$type] = array();
            return false;
        }

        return isset($this->_permuted_values[$type][$value]);
    }
}
