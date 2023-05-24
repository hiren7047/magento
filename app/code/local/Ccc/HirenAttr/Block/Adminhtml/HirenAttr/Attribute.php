<?php

class Ccc_HirenAttr_Block_Adminhtml_HirenAttr_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'hirenAttr';
		$this->_controller = 'adminhtml_hirenAttr_attribute';
		$this->_headerText = Mage::helper('vendor')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('vendor')->__('Add New Attribute');
		parent::__construct();
	}
}