<?php
class Ccc_Sample_Block_Adminhtml_Sample_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'sample_id';
        $this->_blockGroup = 'sample';
        $this->_controller = 'adminhtml_sample';
        $this->_headerText = Mage::helper('sample')->__('New Sample');
         
        $this->_updateButton('save', 'label', Mage::helper('sample')->__('Save Sample'));
        $this->_updateButton('delete', 'label', Mage::helper('sample')->__('Delete Sample'));
        parent::__construct();
         
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('sample')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);
    }
}