<?php
/**
 * Author: Sean Dunagan
 * Created: 8/22/15
 */

class Dunagan_ProcessQueue_Model_Mysql4_Task_Unique
    extends Dunagan_ProcessQueue_Model_Mysql4_Task
{
    public function _construct()
    {
        $this->_init('dunagan_process_queue/task_unique', 'task_id');
    }

    /**
     * Publicly scoped accessor for the protected method
     *
     * @param $code
     * @param $object
     * @param $method
     * @param $unique_id
     * @return array
     */
    public function getUniqueInsertDataArrayTemplate($code, $object, $method, $unique_id)
    {
        return $this->_getUniqueInsertDataArrayTemplate($code, $object, $method, $unique_id);
    }

    protected function _getUniqueInsertDataArrayTemplate($code, $object, $method, $unique_id)
    {
        $insert_data_array_template = parent::_getInsertDataArrayTemplate($code, $object, $method);
        $insert_data_array_template['unique_id'] = $unique_id;
        return $insert_data_array_template;
    }

    protected function _getInsertColumnsArray()
    {
        return array('code', 'unique_id', 'status', 'object', 'method', 'serialized_arguments_object');
    }

    /**
     * This method intended to be used to check if a row has already been created for the unique_id
     *
     * @param $unique_id
     */
    public function getPrimaryKeyByUniqueId($unique_id)
    {
        $table_name = $this->getMainTable();
        $readConnection = $this->getReadConnection();

        $select = $readConnection
                    ->select()
                    ->from($table_name, array('task_id'))
                    ->where('unique_id = ?', $unique_id);

        $unique_task_primary_key = $readConnection->fetchOne($select);

        return $unique_task_primary_key;
    }
}
