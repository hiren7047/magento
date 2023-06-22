<?php
class Ccc_Practice_Block_Adminhtml_Practice extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'practice';
        $this->_controller = 'adminhtml_practice';
        $this->_headerText = Mage::helper('practice')->__('Manage Practice');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('practice')->__('Add New Practice'));
        } else {
            $this->_removeButton('add');
        }

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('practice/adminhtml_practice/' . $action);
    }

}
