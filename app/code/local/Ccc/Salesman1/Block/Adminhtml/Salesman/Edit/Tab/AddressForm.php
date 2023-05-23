<?php

class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_AddressForm extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('address_form',array('legend'=>Mage::helper('address')->__('Address information')));

        $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('address')->__('Address'),
            'required' => false,
            'name' => 'address[address]',
        ));

        $fieldset->addField('city', 'text', array(
            'label' => Mage::helper('address')->__('City'),
            'required' => false,
            'name' => 'address[city]',
        ));

        $fieldset->addField('state', 'text', array(
            'label' => Mage::helper('address')->__('State'),
            'required' => false,
            'name' => 'address[state]',
        ));

        $fieldset->addField('country', 'text', array(
            'label' => Mage::helper('address')->__('Country'),
            'required' => false,
            'name' => 'address[country]',
        ));

        $fieldset->addField('zip_code', 'text', array(
            'label' => Mage::helper('address')->__('Zip Code'),
            'required' => false,
            'name' => 'address[zip_code]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getVendorData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getVendorData());
            Mage::getSingleton('adminhtml/session')->setVendorData(null);
        } elseif ( Mage::registry('address_data') ) {
            $form->setValues(Mage::registry('address_data')->getData());
        }
        return parent::_prepareForm();
    }
}





    