<?php
class Ccc_Practice_Block_Adminhtml_Practice_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('practice_id');
        $this->setDefaultSort('practice_id');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('practice/practice')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('practice_id', array(
            'header'    => Mage::helper('practice')->__('practice Id'),
            'width'     => '50px',
            'index'     => 'practice_id',
            'type'  => 'number',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('practice')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('practice')->__('Sku'),
            'index'     => 'sku'
        ));

        $this->addColumn('price', array(
            'header'    => Mage::helper('practice')->__('Price'),
            'index'     => 'price'
        ));

        $this->addColumn('cost', array(
            'header'    => Mage::helper('practice')->__('Cost'),
            'index'     => 'cost'
        ));

         $this->addColumn('quantity', array(
            'header'    => Mage::helper('practice')->__('Quantity'),
            'index'     => 'quantity'
        ));

        $this->addColumn('description', array(
            'header'    => Mage::helper('practice')->__('Description'),
            'index'     => 'description'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('practice')->__('Status'),
            'index'     => 'status'
        ));

        $this->addColumn('created_time', array(
            'header'    => Mage::helper('practice')->__('Created Time'),
            'index'     => 'created_time'
        ));

        $this->addColumn('update_time', array(
            'header'    => Mage::helper('practice')->__('Update Time'),
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
        $this->setMassactionIdField('practice_id');
        $this->getMassactionBlock()->setFormFieldName('practice');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('practice')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('practice')->__('Are you sure?')
        ));
        return $this;
    }
}
