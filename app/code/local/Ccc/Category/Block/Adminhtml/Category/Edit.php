<?php

class Ccc_Category_Block_Adminhtml_Category_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        
        $this->_objectId = 'category_id';
        $this->_controller = 'adminhtml_category';
        $this->_blockGroup = 'category';
        $this->_headerText = Mage::helper('category')->__('New Category');


        $this->_updateButton('save', 'label', Mage::helper('category')->__('Save Category'));
        $this->_updateButton('delete', 'label', Mage::helper('category')->__('Delete Category'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
    }
}
