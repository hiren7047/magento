<?php
class Ccc_Sample_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_attribute';
        $this->_blockGroup = 'sample';
        $this->_headerText = Mage::helper('sample')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('sample')->__('Add New Attribute');
        parent::__construct();
    }

}
