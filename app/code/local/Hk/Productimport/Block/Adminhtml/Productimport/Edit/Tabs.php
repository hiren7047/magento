<?php

class Hk_Productimport_Block_Adminhtml_Productimport_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('productimport')->__('Productimport Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('productimport')->__('Productimport'),
            'title' => Mage::helper('productimport')->__('Productimport Information'),
            'content' => $this->getLayout()->createBlock('productimport/adminhtml_productimport_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}





    