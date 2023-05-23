<?php
class Hiren_Hiren_Block_Adminhtml_Hiren extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'hiren';
        $this->_controller = 'adminhtml_hiren';
        $this->_headerText = Mage::helper('hiren')->__('Manage');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('hiren')->__('Add New'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('hiren/adminhtml_hiren/' . $action);
    }
}
