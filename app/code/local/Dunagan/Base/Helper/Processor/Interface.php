<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 *
 * Interface Dunagan_Base_Helper_Process_Interface
 */

interface Dunagan_Base_Helper_Processor_Interface
{
    // The following methods are REQUIRED for any class which implements Dunagan_Base_Helper_Processor_Interface

    /**
     * This method should actually execute the logic/functionality of the process
     *
     * @param string $process_code
     * @param Dunagan_Base_Model_Process_Interface $processModelToProcess
     * @return Dunagan_Base_Helper_Processor_Logger_Interface
     */
    public function executeProcess($process_code, Dunagan_Base_Model_Process_Interface $processModelToProcess);

    /**
     * The path would should be passed to Mage::getStoreConfig() to get the configuration(s) for this process
     * e.g. If the path to the process's xml configuration is
     *      <some_module>
    <some_child_node>
    <another_child_node>
    <process_node>  <-- The process path is some_module/some_child_node/another_child_node/process_node
    <process_type_1>
     *                          <delegates>
     *                          </delegates>
     *                          <data>
     *                          </data>
     *                      </process_type_1>
     *                      <process_type_2>
     *                          <delegates>
     *                          </delegates>
     *                          <data>
     *                          </data>
     *                      </process_type_2>
     *                      ...
     *                      ...
     *
     * The return would be some_module/some_child_node/another_child_node/process_node
     *
     * @return string - In the above this would return some_module/some_child_node/another_child_node/process_node
     */
    public function configXmlProcessConfigurationPath();

    /**
     * Should be the classname of the model to create with the configuration data. The model referenced here should be a
     * subclass of Dunagan_Base_Model_Process_Base
     *
     * @param bool $multiple_processes_configured - Are multiple process configurations defined at configXmlProcessConfigurationPath
     * @return string
     */
    public function getProcessModelClassname();

    // The following methods are OPTIONAL for any class which extends abstract class Dunagan_Base_Helper_Processor_Abstract
    /**
     * States whether multiple processes are configured at the xml path defined in configXmlProcessConfigurationPath()
     *
     * @return bool - abstract class Dunagan_Base_Helper_Processor_Abstract will return true by default
     */
    public function areMultipleProcssesConfigured();
}
