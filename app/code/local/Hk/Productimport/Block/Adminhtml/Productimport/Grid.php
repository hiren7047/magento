<?php

class Hk_Productimport_Block_Adminhtml_Productimport_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        // $this->setTemplate('productimport/grid.phtml');
        $this->setId('productimportAdminhtmlProductimportGrid');
        $this->setDefaultSort('productimport_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('productimport/productimport')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('index', array(
            'header'    => Mage::helper('productimport')->__('Index'),
            'align'     => 'left',
            'index'     => 'index',
        ));
         $this->addColumn('product_id', array(
            'header'    => Mage::helper('productimport')->__('Product Id'),
            'align'     => 'left',
            'index'     => 'product_id',
        ));
          $this->addColumn('sku', array(
            'header'    => Mage::helper('productimport')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku',
        ));
           $this->addColumn('name', array(
            'header'    => Mage::helper('productimport')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));
            $this->addColumn('price', array(
            'header'    => Mage::helper('productimport')->__('Price'),
            'align'     => 'left',
            'index'     => 'price',
        ));
              $this->addColumn('cost', array(
            'header'    => Mage::helper('productimport')->__('Cost'),
            'align'     => 'left',
            'index'     => 'cost',
        ));
               $this->addColumn('quaintity', array(
            'header'    => Mage::helper('productimport')->__('Quantity'),
            'align'     => 'left',
            'index'     => 'quaintity',
        ));
                $this->addColumn('brand', array(
            'header'    => Mage::helper('productimport')->__('Brand'),
            'align'     => 'left',
            'index'     => 'brand',
        ));
                 $this->addColumn('brand_id', array(
            'header'    => Mage::helper('productimport')->__('Brand Id'),
            'align'     => 'left',
            'index'     => 'brand_id',
        ));
                        $this->addColumn('collection', array(
            'header'    => Mage::helper('productimport')->__('Collection'),
            'align'     => 'left',
            'index'     => 'collection',
        ));
                 $this->addColumn('collection_id', array(
            'header'    => Mage::helper('productimport')->__('Collection Id'),
            'align'     => 'left',
            'index'     => 'collection_id',
        ));
                        $this->addColumn('description', array(
            'header'    => Mage::helper('productimport')->__('Description'),
            'align'     => 'left',
            'index'     => 'description',
        ));
                 $this->addColumn('status', array(
            'header'    => Mage::helper('productimport')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
        ));
               

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('productimport_id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('productimport_id');
        $this->getMassactionBlock()->setFormFieldName('productimport');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('productimport')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('productimport')->__('Are you sure?')
        ));
        return $this;
    }
}