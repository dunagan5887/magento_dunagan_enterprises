<?php


class Worldview_Source_Block_Adminhtml_Source_Index_Grid
    extends Dunagan_Base_Block_Adminhtml_Widget_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('worldview_source/source')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('code', array(
            'header'    => $this->_getTranslationHelper()->__('Code'),
            'width'     => '25',
            'align'     => 'left',
            'index'     => 'code',
            'type'      => 'text'
        ));

        $this->addColumn('name', array(
            'header'    => $this->_getTranslationHelper()->__('Name'),
            'width'     => '200',
            'align'     => 'left',
            'index'     => 'name',
            'type'      => 'text'
        ));

        $this->addColumn('feed_url', array(
            'header'    => $this->_getTranslationHelper()->__('Feed URL'),
            'align'     => 'left',
            'index'     => 'feed_url',
            'type'      => 'text'
        ));

        $this->addColumn('type', array(
            'header'    => $this->_getTranslationHelper()->__('Feed Type'),
            'width'     => '30',
            'align'     => 'left',
            'index'     => 'type',
            'type'      => 'text'
        ));

        $this->addColumn('active', array(
            'header'    => $this->_getTranslationHelper()->__('Active'),
            'width'     => '30',
            'align'     => 'left',
            'index'     => 'active',
            'type'      => 'text',
            'renderer'  => 'adminhtml/widget_grid_column_renderer_options',
            'options'   => Mage::getModel('eav/entity_attribute_source_boolean')->getOptionArray(),
            'filter'    => 'adminhtml/widget_grid_column_filter_select'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        $url_param_name = $this->getAction()->getObjectParamName();
        return $this->getUrl('*/*/edit', array($url_param_name => $row->getId()));
    }
}
