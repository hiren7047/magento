<?php 
class Ccc_Hiren_Block_Adminhtml_Hiren extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'hiren';
		$this->_controller = 'adminhtml_hiren';
		$this->_headerText = $this->__('Hiren Grid');
		$this->_addButtonLabel = $this->__('Add Hiren');
		parent::__construct();
	}
}