<?php

class Ccc_Hiren_Block_Adminhtml_Hiren_Attribute_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('hiren_attribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('hiren')->__('Attribute Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('main', array(
            'label'     => Mage::helper('hiren')->__('Properties'),
            'title'     => Mage::helper('hiren')->__('Properties'),
            'content'   => $this->getLayout()->createBlock('hiren/adminhtml_hiren_attribute_edit_tab_main')->toHtml(),
            'active'    => true
        ));

        $model = Mage::registry('entity_attribute');

        $this->addTab('labels', array(
            'label'     => Mage::helper('hiren')->__('Manage Label / Options'),
            'title'     => Mage::helper('hiren')->__('Manage Label / Options'),
            'content'   => $this->getLayout()->createBlock('hiren/adminhtml_hiren_attribute_edit_tab_options')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}