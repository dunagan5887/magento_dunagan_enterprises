<?php
/**
 * Author: Sean Dunagan
 * Created: 8/13/15
 */

$installer = $this;

$table_name = $installer->getTable('dunagan_process_queue/task');

$installer->getConnection()->addColumn($table_name, 'optional_task_unique_id', 'varchar(50) NULL');

$installer->endSetup();
