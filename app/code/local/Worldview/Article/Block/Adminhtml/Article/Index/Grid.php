<?php
/**
 * Author: Sean Dunagan
 * Created: 4/6/15
 * Class Worldview_Article_Block_Adminhtml_Source_Container_Grid
 */

class Worldview_Article_Block_Adminhtml_Article_Index_Grid
    extends Dunagan_Base_Block_Adminhtml_Widget_Grid
{
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('worldview_article/article')
                        ->getCollection();

        $source_table = $collection->getResource()->getTable('worldview_source/entity');

        $collection->getSelect()->join(
            array('source' => $source_table),
            'source.entity_id=main_table.feed_source_id',
            array('source.name' => "name")
        );

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('source', array(
            'header'    => $this->_getTranslationHelper()->__('Source'),
            'width'     => '100',
            'align'     => 'left',
            'index'     => 'source.name',
            'type'      => 'text'
        ));

        $this->addColumn('title', array(
            'header'    => $this->_getTranslationHelper()->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
            'type'      => 'text'
        ));

        $this->addColumn('link', array(
            'header'    => $this->_getTranslationHelper()->__('Article Url'),
            'align'     => 'left',
            'index'     => 'link',
            'type'      => 'text'
        ));

        $this->addColumn('article_text', array(
            'header'    => $this->_getTranslationHelper()->__('Article Text'),
            'align'     => 'left',
            'index'     => 'article_text',
            'type'      => 'text'
        ));

        $this->addColumn('publication_date', array(
            'header'    => $this->_getTranslationHelper()->__('Publication Date'),
            'width'     => '30',
            'align'     => 'left',
            'index'     => 'publication_date',
            'type'      => 'datetime'
        ));

        $this->addColumn('is_biased', array(
            'header'    => $this->_getTranslationHelper()->__('Is Biased'),
            'width'     => '30',
            'align'     => 'left',
            'index'     => 'is_biased',
            'type'      => 'text',
            'renderer'  => 'adminhtml/widget_grid_column_renderer_options',
            'options'   => Mage::getModel('eav/entity_attribute_source_boolean')->getOptionArray(),
            'filter'    => 'adminhtml/widget_grid_column_filter_select'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('article' => $row->getId()));
    }
}
