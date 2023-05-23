<?php
class Ccc_Product_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_practice';
        $this->_blockGroup = 'practice';
        $this->_headerText = Mage::helper('practice')->__('Manage practice');
        $this->_addButtonLabel = Mage::helper('practice')->__('Add New practice');
        parent::__construct();
    }
}
