<?php
class Ccc_Sample_Block_Adminhtml_Sample_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('sample_form',array('legend'=>Mage::helper('sample')->__('Sample information')));

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('sample')->__('First Name'),
            'required' => true,
            'name' => 'salesmen[first_name]',
        ));

        $fieldset->addField('last_name', 'text', array(
            'label' => Mage::helper('sample')->__('Last Name'),
            'required' => false,
            'name' => 'salesmen[last_name]',
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('sample')->__('Email'),
            'required' => true,
            'name' => 'salesmen[email]',
        ));

        $fieldset->addField('gender', 'text', array(
            'label' => Mage::helper('sample')->__('Gender'),
            'required' => false,
            'name' => 'salesmen[gender]',
        ));

        $fieldset->addField('mobile', 'text', array(
            'label' => Mage::helper('sample')->__('Mobile'),
            'required' => false,
            'name' => 'salesmen[mobile]',
        ));

        $fieldset->addField('status', 'text', array(
            'label' => Mage::helper('sample')->__('Status'),
            'required' => false,
            'name' => 'salesmen[status]',
        ));
        
        if(Mage::getSingleton('adminhtml/session')->getSampleData())
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSampleData());
            Mage::getSingleton('adminhtml/session')->setSampleData(null);
        } 
        elseif (Mage::registry('sample_data')) 
        {
            $form->setValues(Mage::registry('sample_data')->getData());
        }
        return parent::_prepareForm();
    }
}