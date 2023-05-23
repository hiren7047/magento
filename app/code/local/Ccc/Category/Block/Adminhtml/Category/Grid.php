<?php
class Ccc_Category_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('category_id');
        $this->setDefaultSort('category_id');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('category/category')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('category_id', array(
            'header'    => Mage::helper('category')->__('Category Id'),
            'width'     => '50px',
            'index'     => 'category_id',
            'type'  => 'number',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('category')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('path', array(
            'header'    => Mage::helper('category')->__('Path'),
            'index'     => 'path'
        ));

        $this->addColumn('description', array(
            'header'    => Mage::helper('category')->__('Description'),
            'index'     => 'description'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('category')->__('Status'),
            'index'     => 'status'
        ));

        $this->addColumn('created_time', array(
            'header'    => Mage::helper('category')->__('Created Time'),
            'index'     => 'created_time'
        ));

        $this->addColumn('update_time', array(
            'header'    => Mage::helper('category')->__('Updated Time'),
            'index'     => 'update_time'
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('category_id');
        $this->getMassactionBlock()->setFormFieldName('category');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('category')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('category')->__('Are you sure?')
        ));

        return $this;
    }
}
