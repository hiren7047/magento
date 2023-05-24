<?php
class Ccc_Practice_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    public function _prepareColumns()
    {
        $colums = parent::_prepareColumns();
        $this->addColumn('test',array(
            'header' => Mage::helper('catalog')->__('Hello0000'),
            'width' => '80px'
        ));
        return $colums;
    }
  
}
