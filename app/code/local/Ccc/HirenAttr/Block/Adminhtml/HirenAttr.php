<?php 
class Ccc_HirenAttr_Block_Adminhtml_HirenAttr extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'hirenAttr';
		$this->_controller = 'adminhtml_hirenAttr';
		$this->_headerText = $this->__('HirenAttr Grid');
		$this->_addButtonLabel = $this->__('Add HirenAttr');
		parent::__construct();
	}
}