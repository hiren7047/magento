<?php
class Ccc_HirenAttr_Block_Adminhtml_HirenAttr_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{	
	public function __construct()
	{		
		$this->_blockGroup = 'hirenAttr';
        $this->_controller = 'adminhtml_hirenAttr';
        $this->_headerText = 'Add HirenAttr';
        parent::__construct();
        if(!$this->getRequest()->getParam('set') && !$this->getRequest()->getParam('id'))
		{
			$this->_removeButton('save');
		} 
	}
}