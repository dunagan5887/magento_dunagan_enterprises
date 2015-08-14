<?php
/**
 * Author: Sean Dunagan
 * Created: 8/13/15
 * Class Dunagan_ProcessQueue_Model_Task
 */

class Dunagan_ProcessQueue_Model_Task
    extends Mage_Core_Model_Abstract
    implements Dunagan_ProcessQueue_Model_Task_Interface
{
    const ERROR_INVALID_OBJECT_CLASS = 'The specified object class %s does not refer to any existing classes in the system';
    const ERROR_METHOD_DOES_NOT_EXIST = 'Method %s does exist on object of class %s';

    const STATUS_PENDING = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_COMPLETE = 3;
    const STATUS_ERROR = 4;
    const STATUS_ABORTED = 5;

    protected $_valid_statuses = array(self::STATUS_PENDING, self::STATUS_PROCESSING, self::STATUS_COMPLETE, self::STATUS_ERROR, self::STATUS_ABORTED);

    protected function _construct()
    {
        $this->_init('dunagan_process_queue/task');
    }

    protected function _beforeSave()
    {
        $status = $this->getStatus();
        if (!in_array($status, $this->_valid_statuses))
        {
            // Default to Pending, assume task is just being created
            $this->setStatus(self::STATUS_PENDING);
        }

        $created_at = $this->getCreatedAt();
        if (empty($created_at))
        {
            $current_gmt_timestamp = Mage::getSingleton('core/date')->gmtTimestamp();
            $this->setCreatedAt($current_gmt_timestamp);
        }

        return parent::_beforeSave();
    }

    public function getStatus()
    {
        return parent::getStatus();
    }

    public function executeTask()
    {
        $object_class = $this->getObject();
        $object = Mage::getModel($object_class);
        if (!is_object($object))
        {
            $error_message = Mage::helper('dunagan_process_queue')->__(self::ERROR_INVALID_OBJECT_CLASS, $object_class);
            throw new Exception($error_message);
        }

        $method = $this->getMethod();
        if (!method_exists($object, $method))
        {
            $error_message = Mage::helper('dunagan_process_queue')->__(self::ERROR_METHOD_DOES_NOT_EXIST, $method, $object_class);
            throw new Exception($error_message);
        }

        $argumentsObject = $this->getArgumentsObject();

        return $object->$method($argumentsObject);
    }

    public function getArgumentsObject()
    {
        $serialized_arguments_object_string = $this->getSerializedArgumentsObject();
        $argumentsObject = unserialize($serialized_arguments_object_string);

        if (!is_object($argumentsObject))
        {
            $argumentsObject = new stdClass();
        }

        return $argumentsObject;
    }

    public function setTaskAsErrored()
    {
        return $this->getResource()->setTaskAsErrored($this);
    }

    public function setTaskAsCompleted()
    {
        return $this->getResource()->setTaskAsCompleted($this);
    }

    public function attemptUpdatingRowAsProcessing()
    {
        return $this->getResource()->attemptUpdatingRowAsProcessing($this);
    }

    public function selectForUpdate()
    {
        return $this->getResource()->selectForUpdate($this);
    }
}
