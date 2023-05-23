<?php
class Hiren_Hiren_Block_Adminhtml_Hiren_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        $fieldset = $form->addFieldset('sample_form',array('legend'=>Mage::helper('hiren')->__('information')));

        $fieldset->addField('first_name', 'text', array(
            'label' => Mage::helper('hiren')->__('First Name'),
            'required' => true,
            'name' => 'hiren[first_name]',
        ));

        $fieldset->addField('last_name', 'text', array(
            'label' => Mage::helper('hiren')->__('Last Name'),
            'required' => false,
            'name' => 'hiren[last_name]',
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('hiren')->__('Email'),
            'required' => true,
            'name' => 'hiren[email]',
        ));

        $fieldset->addField('gender', 'text', array(
            'label' => Mage::helper('hiren')->__('Gender'),
            'required' => false,
            'name' => 'hiren[gender]',
        ));

        $fieldset->addField('mobile', 'text', array(
            'label' => Mage::helper('hiren')->__('Mobile'),
            'required' => false,
            'name' => 'hiren[mobile]',
        ));

        $fieldset->addField('status', 'text', array(
            'label' => Mage::helper('hiren')->__('Status'),
            'required' => false,
            'name' => 'hiren[status]',
        ));
        
        if(Mage::getSingleton('adminhtml/session')->getSampleData())
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSampleData());
            Mage::getSingleton('adminhtml/session')->setSampleData(null);
        } 
        elseif (Mage::registry('hiren_data')) 
        {
            $form->setValues(Mage::registry('hiren_data')->getData());
        }
        return parent::_prepareForm();
    }
}