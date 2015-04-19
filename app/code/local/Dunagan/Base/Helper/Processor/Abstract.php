<?php
/**
 * Author: Sean Dunagan
 * Date: 4/9/15
 * Class Dunagan_Base_Helper_Process_Abstract
 */

abstract class Dunagan_Base_Helper_Processor_Abstract
    implements Dunagan_Base_Helper_Processor_Interface
{
    const EXCEPTION_DURING_EXECUTE_PROCESSES = 'Exception occurred during execution of %s::executeProcesses() : %s';
    const EXCEPTION_DURING_PROCESS_PROCESSING = 'An exception occurred while processing Process of class %s with code %s: %s';
    const ERROR_NO_HELPER_LOADED = 'Helper with classname %s could not be loaded';
    const EXCEPTION_COULD_NOT_SET_DELEGATE = 'An exception occurred while trying to set delegate with classname %s on process model with classname %s: %s';

    // Documentation on the following methods is found in Dunagan_Base_Helper_Processor_Interface
    abstract public function executeProcess($process_code, Dunagan_Base_Model_Process_Interface $processModelToProcess);

    abstract public function configXmlProcessConfigurationPath();

    abstract public function getProcessModelClassname();

    public function areMultipleProcssesConfigured()
    {
        return true;
    }

    /**
     * @return array
     * @throws Exception - We want to let the calling block decide how to handle the exception
     */
    public function executeProcesses()
    {
        $process_log_data_objects_array = array();

        try
        {
            $multiple_processes_are_configured = $this->areMultipleProcssesConfigured();
            $processesToLoadFromConfiguration = $this->loadProcessesFromConfigXml($multiple_processes_are_configured);

            foreach ($processesToLoadFromConfiguration as $process_code => $processToExecute)
            {
                try
                {
                    $processLogData = $this->executeProcess($process_code, $processToExecute);
                    $process_log_data_objects_array[$process_code] = $processLogData;
                }
                catch(Exception $e)
                {
                    $error_message = sprintf(self::EXCEPTION_DURING_PROCESS_PROCESSING, get_class($processToExecute), $process_code, $e->getMessage());
                    Mage::log($error_message);
                    $exceptionToLog = new Exception($error_message, $e->getCode(), $e);
                    Mage::logException($exceptionToLog);
                    throw $exceptionToLog;
                }

            }
        }
        catch (Exception $e)
        {
            $error_message = sprintf(self::EXCEPTION_DURING_EXECUTE_PROCESSES, __CLASS__, $e->getMessage());
            Mage::log($error_message);
            $exceptionToLog = new Exception($error_message, $e->getCode(), $e);
            Mage::logException($exceptionToLog);
            throw $exceptionToLog;
        }

        return $process_log_data_objects_array;
    }

    /**
     * Constructs Dunagan_Base_Model_Process_Interface objects from configuration xml data
     *
     * @param bool $multiple_processes_configured - Are multiple process nodes present at configXmlProcessConfigurationPath() value
     * @return array containing Dunagan_Base_Model_Process_Interface object(s) whose configuration is declared at configXmlProcessConfigurationPath()
     */
    public function loadProcessesFromConfigXml($multiple_processes_configured = true)
    {
        $process_config_xml_path = $this->configXmlProcessConfigurationPath();

        $process_configuration_node = Mage::getStoreConfig($process_config_xml_path);

        $process_models_array = array();

        if ($multiple_processes_configured)
        {
            // If $multiple_processes_configured is true, then we have an array to iterate over
            foreach ($process_configuration_node as $process_code => $process_configuration_array)
            {
                $processModel = $this->_productProcessModelFromConfigurationNodeArray($process_code, $process_configuration_array);
                $process_models_array[$process_code] = $processModel;
            }
        }
        else
        {
            // Otherwise there is just one default process
            $processModel = $this->_productProcessModelFromConfigurationNodeArray('default', $process_configuration_node);
            $process_models_array['default'] = $processModel;
        }

        return $process_models_array;
    }

    protected function _productProcessModelFromConfigurationNodeArray($process_code, $process_configuration_array)
    {
        $processModel = Mage::getModel($this->getProcessModelClassname());
        $processModel->setCode($process_code);

        // If delegates were declared for this process, load them and set them on the Process object
        $array_of_delegates = isset($process_configuration_array['delegates']) ? $process_configuration_array['delegates'] : null;
        if (is_array($array_of_delegates) && !empty($array_of_delegates))
        {
            foreach ($array_of_delegates as $delegate_code => $delegate_helper_classname)
            {
                try
                {
                    $delegateHelper = Mage::helper($delegate_helper_classname);
                    if(!is_object($delegateHelper))
                    {
                        $error_message = sprintf(self::ERROR_NO_HELPER_LOADED, $delegate_helper_classname);
                        throw new Dunagan_Base_Model_Process_Exception($error_message);
                    }

                    // TODO Verify that $delegateHelper implements Dunagan_Base_Model_Process_Interface
                    $processModel->setDelegate($delegate_code, $delegateHelper);
                }
                catch(Exception $e)
                {
                    // TODO Test this
                    $error_message = sprintf(self::EXCEPTION_COULD_NOT_SET_DELEGATE, $delegate_helper_classname, $this->getProcessModelClassname(), $e->getMessage());
                    Mage::log($error_message);
                    $exceptionToLog = new Dunagan_Base_Model_Process_Exception($error_message);
                    Mage::logException($exceptionToLog);
                    throw $exceptionToLog;
                }
            }
        }
        // If any data was declared for this process, set it on the Process object
        $process_data = isset($process_configuration_array['data']) ? $process_configuration_array['data'] : null;
        if (is_array($process_data) && !empty($process_data))
        {
            foreach ($process_data as $data_key => $data_value)
            {
                $processModel->setData($data_key, $data_value);
            }
        }

        return $processModel;
    }
}
