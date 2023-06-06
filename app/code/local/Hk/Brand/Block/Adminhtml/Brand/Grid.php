<?php

class Hk_Brand_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('brandId');
        $this->setDefaultSort('brand_id');
        $this->setDefaultDir('DESC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('brand/brand')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('brand_id', array(
            'header'    => Mage::helper('brand')->__('Brand Id'),
            'align'     => 'left',
            'index'     => 'brand_id'
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('brand')->__('Name'),
            'align'     => 'left',
            'index'     => 'name'
        ));

        $this->addColumn('image', array(
            'header'    => Mage::helper('brand')->__('Image'),
            'align'     => 'left',
            'index'     => 'image',
            'renderer' => 'brand/adminhtml_brand_grid_renderer_image',
        ));

        $this->addColumn('description', array(
            'header'    => Mage::helper('brand')->__('Description'),
            'align'     => 'left',
            'index'     => 'description',
        ));
        
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('brand_id');
        $this->getMassactionBlock()->setFormFieldName('brand');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('brand')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('brand')->__('Are you sure?')
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('brand_id' => $row->getId()));
    }
   
}