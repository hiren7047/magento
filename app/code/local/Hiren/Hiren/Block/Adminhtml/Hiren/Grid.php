<?php
class Hiren_Hiren_Block_Adminhtml_Hiren_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('hirenAdminhtmlHirenGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('hiren/hiren')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('id', array(
            'header'    => Mage::helper('hiren')->__('Id'),
            'align'     => 'left',
            'index'     => 'id',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('hiren')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('hiren')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('hiren')->__('status'),
            'align'     => 'left',
            'index'     => 'status'
        ));
        
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('hiren')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at'
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('hiren')->__('Updated At'),
            'align'     => 'left',
            'index'     => 'updated_at'
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('hiren');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('hiren')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('hiren')->__('Are you sure?')
        ));
        return $this;
    }
}