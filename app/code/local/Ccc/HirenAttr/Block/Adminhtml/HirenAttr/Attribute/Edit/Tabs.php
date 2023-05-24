<?php

class Ccc_HirenAttr_Block_Adminhtml_HirenAttr_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('hirenAttr_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('hirenAttr')->__('Attribute Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main', array(
            'label'     => Mage::helper('hirenAttr')->__('Properties'),
            'title'     => Mage::helper('hirenAttr')->__('Properties'),
            'content'   => $this->getLayout()->createBlock('hirenAttr/adminhtml_hirenAttr_attribute_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $model = Mage::registry('entity_attribute');

        $this->addTab('labels', array(
            'label'     => Mage::helper('hirenAttr')->__('Manage Label / Options'),
            'title'     => Mage::helper('hirenAttr')->__('Manage Label / Options'),
            'content'   => $this->getLayout()->createBlock('hirenAttr/adminhtml_hirenAttr_attribute_edit_tab_options')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}