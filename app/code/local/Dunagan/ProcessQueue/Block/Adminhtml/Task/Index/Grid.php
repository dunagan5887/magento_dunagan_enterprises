<?php
/**
 * Author: Sean Dunagan
 * Created: 9/14/15
 */

class Dunagan_ProcessQueue_Block_Adminhtml_Task_Index_Grid
    extends Dunagan_Base_Block_Adminhtml_Widget_Grid
{
    protected function _prepareColumns()
    {
        $this->addColumn('action', array(
            'header'    => $this->_getTranslationHelper()->__('Action'),
            'width'     => '50px',
            'type'      => 'action',
            'getter'    => 'getId',
            'renderer'  => 'dunagan_process_queue/adminhtml_widget_grid_column_renderer_action',
            'filter'    => false,
            'sortable'  => false
        ));

        $this->addColumn('code', array(
            'header'    => $this->_getTranslationHelper()->__('Code'),
            'align'     => 'left',
            'index'     => 'code',
            'type'      => 'text'
        ));

        $this->addColumn('status', array(
            'header'    => $this->_getTranslationHelper()->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getModel('dunagan_process_queue/source_task_status')->getOptionArray()
        ));

        $this->addColumn('object', array(
            'header'    => $this->_getTranslationHelper()->__('Object'),
            'align'     => 'left',
            'index'     => 'object',
            'type'      => 'text'
        ));

        $this->addColumn('method', array(
            'header'    => $this->_getTranslationHelper()->__('Method'),
            'align'     => 'left',
            'index'     => 'method',
            'type'      => 'text'
        ));

        $this->addColumn('serialized_arguments_object', array(
            'header'    => $this->_getTranslationHelper()->__('Serialized Arguments Object'),
            'width'     => '250',
            'align'     => 'left',
            'index'     => 'serialized_arguments_object',
            'type'      => 'text'
        ));

        $this->addColumn('status_message', array(
            'header'    => $this->_getTranslationHelper()->__('Status Message'),
            'width'     => '250',
            'align'     => 'left',
            'index'     => 'status_message',
            'type'      => 'text'
        ));

        $this->addColumn('created_at', array(
            'header'    => $this->_getTranslationHelper()->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at',
            'type'      => 'datetime'
        ));

        $this->addColumn('last_executed_at', array(
            'header'    => $this->_getTranslationHelper()->__('Last Executed At'),
            'align'     => 'left',
            'index'     => 'last_executed_at',
            'type'      => 'datetime',
            'renderer'  => 'dunagan_base/adminhtml_widget_grid_column_renderer_datetime',
        ));

        return parent::_prepareColumns();
    }
}
