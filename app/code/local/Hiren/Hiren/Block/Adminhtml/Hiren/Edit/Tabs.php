<?php
class Hiren_Hiren_Block_Adminhtml_Hiren_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs 
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('hiren')->__('Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
        'label' => Mage::helper('hiren')->__('Information'),
        'title' => Mage::helper('hiren')->__('Information'),
        'content' => $this->getLayout()->createBlock('hiren/adminhtml_hiren_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}