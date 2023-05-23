<?php
class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('salesman_form',array('legend'=>Mage::helper('salesman')->__('Salesman information')));

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('salesman')->__('First Name'),
            'required' => true,
            'name' => 'salesmen[first_name]',
        ));

        $fieldset->addField('last_name', 'text', array(
            'label' => Mage::helper('salesman')->__('Last Name'),
            'required' => false,
            'name' => 'salesmen[last_name]',
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('salesman')->__('Email'),
            'required' => true,
            'name' => 'salesmen[email]',
        ));

        $fieldset->addField('gender', 'text', array(
            'label' => Mage::helper('salesman')->__('Gender'),
            'required' => false,
            'name' => 'salesmen[gender]',
        ));

        $fieldset->addField('mobile', 'text', array(
            'label' => Mage::helper('salesman')->__('Mobile'),
            'required' => false,
            'name' => 'salesmen[mobile]',
        ));

        $fieldset->addField('status', 'text', array(
            'label' => Mage::helper('salesman')->__('Status'),
            'required' => false,
            'name' => 'salesmen[status]',
        ));
        
        if(Mage::getSingleton('adminhtml/session')->getSalesmanData())
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSalesmanData());
            Mage::getSingleton('adminhtml/session')->setSalesmanData(null);
        } 
        elseif (Mage::registry('salesman_data')) 
        {
            $form->setValues(Mage::registry('salesman_data')->getData());
        }
        return parent::_prepareForm();
    }
}