<?php

class Ccc_Practice_Block_Adminhtml_Eight_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('practiceAdminhtmlPracticeGrid');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->getSelect()
            ->joinLeft(
                array('oi' => Mage::getSingleton('core/resource')->getTableName('sales/order_item')),
                'e.entity_id = oi.product_id',
                array('sold_quantity' => 'SUM(oi.qty_ordered)')
            )
            ->group('e.entity_id');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array( 
            'header'    => Mage::helper('practice')->__('Product Id'),
            'align'     => 'left',
            'index'     => 'entity_id',
        ));

        $this->addColumn('sku', array( 
            'header'    => Mage::helper('practice')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku',
        ));

        $this->addColumn('sold_quantity', array( 
            'header'    => Mage::helper('practice')->__('Sold Quantity'),
            'align'     => 'left',
            'index'     => 'sold_quantity',
            'renderer'     => 'Ccc_Practice_Block_Adminhtml_Eight_Renderer_Value',
        ));

        return parent::_prepareColumns();
    }
}