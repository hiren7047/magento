<?php
class Ccc_Product_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('product_id');
        $this->setDefaultSort('product_id');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('product/product')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('product_id', array(
            'header'    => Mage::helper('product')->__('Product Id'),
            'width'     => '50px',
            'index'     => 'product_id',
            'type'  => 'number',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('product')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('product')->__('Sku'),
            'index'     => 'sku'
        ));

        $this->addColumn('price', array(
            'header'    => Mage::helper('product')->__('Price'),
            'index'     => 'price'
        ));

        $this->addColumn('cost', array(
            'header'    => Mage::helper('product')->__('Cost'),
            'index'     => 'cost'
        ));

         $this->addColumn('quantity', array(
            'header'    => Mage::helper('product')->__('Quantity'),
            'index'     => 'quantity'
        ));

        $this->addColumn('description', array(
            'header'    => Mage::helper('product')->__('Description'),
            'index'     => 'description'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('product')->__('Status'),
            'index'     => 'status'
        ));

        $this->addColumn('created_time', array(
            'header'    => Mage::helper('product')->__('Created Time'),
            'index'     => 'created_time'
        ));

        $this->addColumn('update_time', array(
            'header'    => Mage::helper('product')->__('Update Time'),
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
        $this->setMassactionIdField('product_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('product')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('product')->__('Are you sure?')
        ));
        return $this;
    }
}
