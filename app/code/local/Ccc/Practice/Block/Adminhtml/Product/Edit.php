<?php

class Ccc_Practice_Block_Adminhtml_Practice_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'practice_id';
        $this->_controller = 'adminhtml_practice';
        $this->_blockGroup = 'practice';
        $this->_headerText = Mage::helper('practice')->__('New practice');

        $this->_updateButton('save', 'label', Mage::helper('practice')->__('Save practice'));
        $this->_updateButton('delete', 'label', Mage::helper('practice')->__('Delete practice'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
    }
}
