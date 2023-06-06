<?php
class Hk_Idx_Block_Adminhtml_Idx extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    { 
        $this->_blockGroup = 'idx';
        $this->_controller = 'adminhtml_idx';
        $this->_headerText = Mage::helper('idx')->__('Manage idx');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('idx')->__('Add New idx'));
        } else {
            $this->_removeButton('add');
        }
        
        $this->_addButton('brand', array(
            'label'     => Mage::helper('idx')->__('Brand'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/brand')}')",
        ));

        $this->_addButton('collection', array(
            'label'     => Mage::helper('idx')->__('Collection'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/collection')}')",
        ));

        $this->_addButton('product', array(
            'label'     => Mage::helper('idx')->__('Product'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/product')}')",
        ));
        $this->_removeButton('reset');
        $this->_removeButton('delete');
        $this->_removeButton('save');

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('idx/adminhtml_idx/' . $action);
    }

}