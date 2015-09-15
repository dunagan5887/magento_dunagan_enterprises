<?php
/**
 * Author: Sean Dunagan
 * Created: 9/14/15
 */

class Dunagan_ProcessQueue_Block_Adminhtml_Task_Unique_Index_Grid
    extends Dunagan_ProcessQueue_Block_Adminhtml_Task_Index_Grid
{
    protected function _prepareColumns()
    {
        $this->addColumn('unique_id', array(
            'header'    => $this->_getTranslationHelper()->__('Unique Id'),
            'width'     => '100',
            'align'     => 'left',
            'index'     => 'unique_id',
            'type'      => 'text'
        ));

        return parent::_prepareColumns();
    }
}
