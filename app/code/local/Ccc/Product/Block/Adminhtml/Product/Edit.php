<?php

class Ccc_Product_Block_Adminhtml_Product_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'product_id';
        $this->_controller = 'adminhtml_product';
        $this->_blockGroup = 'product';
        $this->_headerText = Mage::helper('product')->__('New Product');

        $this->_updateButton('save', 'label', Mage::helper('product')->__('Save Product'));
        $this->_updateButton('delete', 'label', Mage::helper('product')->__('Delete Product'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
    }
}
