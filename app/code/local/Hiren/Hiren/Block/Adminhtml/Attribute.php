<?php
class Hiren_Hiren_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_attribute';
        $this->_blockGroup = 'hiren';
        $this->_headerText = Mage::helper('hiren')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('hiren')->__('Add New Attribute');
        parent::__construct();
    }

}
