<?php

class Ccc_Practice_Block_Adminhtml_Practice_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('practice_form',array('legend'=>Mage::helper('practice')->__('Practice information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('practice')->__('Name'),
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('sku', 'text', array(
            'label' => Mage::helper('practice')->__('SKU'),
            'required' => true,
            'name' => 'sku',
        ));

        $fieldset->addField('price', 'text', array(
            'label' => Mage::helper('practice')->__('Price'),
            'required' => true,
            'name' => 'price',
        ));

        $fieldset->addField('cost', 'text', array(
            'label' => Mage::helper('practice')->__('Cost'),
            'required' => false,
            'name' => 'cost',
        ));

        $fieldset->addField('quantity', 'text', array(
            'label' => Mage::helper('practice')->__('Quantity'),
            'required' => false,
            'name' => 'quantity',
        ));

        $fieldset->addField('description', 'text', array(
            'label' => Mage::helper('practice')->__('Description'),
            'required' => false,
            'name' => 'description',
        ));

        $fieldset->addField('status', 'text', array(
            'label' => Mage::helper('practice')->__('Status'),
            'required' => false,
            'name' => 'status',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } elseif ( Mage::registry('practice_data') ) {
            $form->setValues(Mage::registry('practice_data')->getData());
        }
        return parent::_prepareForm();
    }

}





    