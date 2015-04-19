<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 6:32 PM
 */

abstract class Worldview_Source_Model_Abstract
    extends Mage_Core_Model_Abstract
    implements Worldview_Source_Model_Interface
{
    const ERROR_SOURCE_CODE_NOT_SET = 'Attempted to retrieve a source code for an object of class %s, but the source code was empty.';

    public function getSourceCode()
    {
        $source_code = $this->getCode();

        if (empty($source_code))
        {
            $error_message = sprintf(self::ERROR_SOURCE_CODE_NOT_SET, __CLASS__);
            throw new Exception($error_message);
        }

        return $source_code;
    }
}
