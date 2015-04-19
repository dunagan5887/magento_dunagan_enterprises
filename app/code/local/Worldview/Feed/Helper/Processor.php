<?php
/**
 * Author: Sean Dunagan
 * Created: 4/4/15 8:21 PM
 *
 * class Worldview_Feed_Helper_Processor
 */
abstract class Worldview_Feed_Helper_Processor
    extends Dunagan_Base_Helper_Processor_Abstract
{
    const WORLDVIEW_FEED_PROCESS_CONFIGURATION_PATH = 'worldview/feed/process';

    abstract protected function _getProcessConfigurationSubPath();

    public function configXmlProcessConfigurationPath()
    {
        $sub_path = $this->_getProcessConfigurationSubPath();
        $full_config_path = self::WORLDVIEW_FEED_PROCESS_CONFIGURATION_PATH . '/' . $sub_path;
        return $full_config_path;
    }
}
