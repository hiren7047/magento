<?php
class Ccc_Sample_Block_Adminhtml_Sample_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sampleAdminhtmlSampleGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('sample/sample')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('sample_id', array(
            'header'    => Mage::helper('sample')->__('Sample Id'),
            'align'     => 'left',
            'index'     => 'sample_id',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('sample')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('sample')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('sample')->__('status'),
            'align'     => 'left',
            'index'     => 'status'
        ));
        
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('sample')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at'
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('sample')->__('Updated At'),
            'align'     => 'left',
            'index'     => 'updated_at'
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('sample_id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('sample_id');
        $this->getMassactionBlock()->setFormFieldName('sample');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('sample')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('sample')->__('Are you sure?')
        ));
        return $this;
    }
}