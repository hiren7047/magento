<?php

class Ccc_Practice_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
    protected function _prepareColumns()
    {
        $columns = parent::_prepareColumns();
        // $this->addColumn('new',
        //     array(
        //         'header'=> Mage::helper('catalog')->__('new'),
        //         'index' => 'new',
        // ));

        // $this->removeColumn('name');

        return $columns;
    }
}
