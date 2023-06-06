<?php

class Hk_Banner_Block_Adminhtml_Bannergroup extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        
        $this->_blockGroup = 'banner';
        $this->_controller = 'adminhtml_bannergroup';
        $this->_headerText = Mage::helper('banner')->__('Manage Banner Group');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('banner')->__('Add New Banner Group'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('banner/adminhtml_bannergroup/' . $action);
    }

}