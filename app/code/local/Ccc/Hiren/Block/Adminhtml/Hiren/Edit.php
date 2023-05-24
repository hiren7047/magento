<?php
class Ccc_Hiren_Block_Adminhtml_Hiren_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{	
	public function __construct()
	{		
		$this->_blockGroup = 'hiren';
        $this->_controller = 'adminhtml_hiren';
        $this->_headerText = 'Add Hiren';
        parent::__construct();
        if(!$this->getRequest()->getParam('set') && !$this->getRequest()->getParam('id'))
		{
			$this->_removeButton('save');
		} 
	}
}