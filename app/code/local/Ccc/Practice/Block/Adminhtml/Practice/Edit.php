<?php

class Ccc_Practice_Block_Adminhtml_Practice_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'practice_id';
        $this->_blockGroup = 'practice';
        $this->_controller = 'adminhtml_practice';
        $this->_headerText = Mage::helper('practice')->__('New Practice');
         
        $this->_updateButton('save', 'label', Mage::helper('practice')->__('Save Practice'));
        $this->_updateButton('delete', 'label', Mage::helper('practice')->__('Delete Practice'));
        parent::__construct();
         
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('practice')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);
    }
}