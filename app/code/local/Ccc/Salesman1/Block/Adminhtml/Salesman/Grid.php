<?php
/**
 * 
 */
class Ccc_Salesman_Block_Adminhtml_Salesman_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('salesmanAdminhtmlSalesmanGrid');
        $this->setDefaultSort('salesman_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('salesman/salesman')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('salesman_id', array(
            'header'    => Mage::helper('salesman')->__('Salesman Id'),
            'align'     => 'left',
            'index'     => 'salesman_id',
        ));

        $this->addColumn('first_name', array(
            'header'    => Mage::helper('salesman')->__('First Name'),
            'align'     => 'left',
            'index'     => 'first_name'
        ));

        $this->addColumn('last_name', array(
            'header'    => Mage::helper('salesman')->__('Last Name'),
            'align'     => 'left',
            'index'     => 'last_name'
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('salesman')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

        $this->addColumn('gender', array(
            'header'    => Mage::helper('salesman')->__('Gender'),
            'align'     => 'left',
            'index'     => 'gender'
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('salesman')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('salesman')->__('status'),
            'align'     => 'left',
            'index'     => 'status'
        ));
        
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('salesman')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at'
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('salesman')->__('Updated At'),
            'align'     => 'left',
            'index'     => 'updated_at'
        ));
        
//        $this->addColumn('action',
//            array(
//                'header'    =>  Mage::helper('salesman')->__('Action'),
//                'width'     => '100',
//                'type'      => 'action',
//                'getter'    => 'getId',
//                'actions'   => array(
//                    array(
//                        'caption'   => Mage::helper('salesman')->__('PRICE'),
//                        'url'       => array('base'=> 'salesman/salesman_price/index'),
//                        'field'     => 'salesman_id'
//                    )
//                ),
//                'filter'    => false,
//                'sortable'  => false,
//                'index'     => 'stores',
//                'is_system' => true,
//        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('salesman_id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('salesman_id');
        $this->getMassactionBlock()->setFormFieldName('salesman');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('salesman')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('salesman')->__('Are you sure?')
        ));
        return $this;
    }
}