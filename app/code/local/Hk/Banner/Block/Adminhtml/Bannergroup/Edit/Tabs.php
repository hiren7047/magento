<?php

class Hk_Banner_Block_Adminhtml_Bannergroup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('banner')->__('Banner Group Information'));
    }
    
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('banner')->__('Banner Group'),
            'title' => Mage::helper('banner')->__('Banner Group Information'),
            'content' => $this->getLayout()->createBlock('banner/adminhtml_bannergroup_edit_tab_form')->toHtml(),
        ));

        if($this->getRequest()->getParam('group_id')){
             $this->addTab('group_10', array(
            'label'     => Mage::helper('catalog')->__('Images'),
            'content'   => $this->getLayout()->createBlock('banner/adminhtml_bannergroup_edit_form_gallery_content',
                'banner.adminhtml.bannergroup.edit.form.gallery.content')
                    ->toHtml(),
        ));
        }

        return parent::_beforeToHtml();
    }
}





    