<?php

class Ccc_Category_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('category_form',array('legend'=>Mage::helper('category')->__('Category information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('category')->__('Name'),
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('description', 'text', array(
            'label' => Mage::helper('category')->__('Description'),
            'required' => false,
            'name' => 'description',
        ));

        $fieldset->addField('status', 'text', array(
            'label' => Mage::helper('category')->__('Status'),
            'required' => false,
            'name' => 'status',
        ));

        $fieldset->addField('parent', 'text', array(
            'label' => Mage::helper('category')->__('Parent Category'),
            'required' => false,
            'name' => 'parent',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } elseif ( Mage::registry('category_data') ) {
            $form->setValues(Mage::registry('category_data')->getData());
        }
        return parent::_prepareForm();


    }

}





    