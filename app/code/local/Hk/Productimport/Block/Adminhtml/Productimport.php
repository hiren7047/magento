<?php

class Hk_Productimport_Block_Adminhtml_Productimport extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        
        $this->_blockGroup = 'productimport';
        $this->_controller = 'adminhtml_productimport';
        $this->_headerText = Mage::helper('productimport')->__('Manage Productimports');

        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('add', 'label', Mage::helper('productimport')->__('Add New Productimport'));
        } else {
            $this->_removeButton('add');
        }
        $this->_addButton('productimport_productimport', array(
        'label' => $this->__('Export Sample Csv'),
        'onclick' => "setLocation('{$this->getUrl('*/*/download')}')",
    ));
        $this->_addButton('brand', array(
            'label'     => Mage::helper('productimport')->__('Brand'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/brand')}')",
        ));

        $this->_addButton('collection', array(
            'label'     => Mage::helper('productimport')->__('Collection'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/collection')}')",
        ));

        $this->_addButton('product', array(
            'label'     => Mage::helper('productimport')->__('Product'),
            'onclick'   => "setLocation('{$this->getUrl('*/*/product')}')",
        ));
        $this->_headerText = $this->__('Import Products');
        $this->_removeButton('reset');
        $this->_removeButton('delete');
        $this->_removeButton('save');

    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('productimport/adminhtml_productimport/' . $action);
    }

     protected function _prepareLayout()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'import_form',
            'action'    => $this->getUrl('*/*/import'),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $form->addField('csv_file', 'file', array(
            'name'      => 'csv_file',
            'label'     => $this->__('CSV File'),
            'title'     => $this->__('CSV File'),
            'required'  => true,
        ));

        $this->setForm($form);
        return parent::_prepareLayout();
    }

}