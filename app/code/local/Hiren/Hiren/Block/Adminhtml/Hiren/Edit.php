<?php
class Hiren_Hiren_Block_Adminhtml_Hiren_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'hiren';
        $this->_controller = 'adminhtml_hiren';
        $this->_headerText = Mage::helper('hiren')->__('New');
         
        $this->_updateButton('save', 'label', Mage::helper('hiren')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('hiren')->__('Delete'));
        parent::__construct();
         
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('hiren')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);
    }
}