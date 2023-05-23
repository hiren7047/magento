<?php
class Ccc_Sample_Block_Adminhtml_Sample_Edit_Tab_Price extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sampleAdminhtmlsampleGrid');
        $this->setDefaultSort('sample_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('sample/sample_price')->getCollection();
        $collection->getSelect()
                    ->joinRight(
                                array('p' =>'product'),
                                'p.product_id = main_table.product_id'
                            );
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => Mage::helper('product')->__('Product Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('sample')->__('SKU'),
            'align'     => 'left',
            'index'     => 'sku'
        ));

        $this->addColumn('price', array(
            'header'    => Mage::helper('sample')->__('Price'),
            'align'     => 'left',
            'index'     => 'price'
        ));

        $this->addColumn('cost', array(
            'header'    => Mage::helper('sample')->__('Cost'),
            'align'     => 'left',
            'index'     => 'cost'
        ));

        $this->addColumn('s_price', array(
            'header'    => Mage::helper('sample')->__('Sample Price'),
            'align'     => 'left',
            'index'     => 's_price',
            'type'      => 'input'
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('sample_id');
        $this->getMassactionBlock()->setFormFieldName('sample');

        $this->getMassactionBlock()->addItem('update', array(
             'label'    => Mage::helper('sample')->__('Update Price'),
             'url'      => $this->getUrl('*/*/massUpdate'),
             'confirm'  => Mage::helper('sample')->__('Are you sure?')
        ));
        return $this;
    }
}