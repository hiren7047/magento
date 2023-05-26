<?php
class Hk_Eavmgmt_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_attribute';
        $this->_blockGroup = 'eavmgmt';
        $this->_headerText = Mage::helper('eavmgmt')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('eavmgmt')->__('Export');
        parent::__construct();
    }

}
