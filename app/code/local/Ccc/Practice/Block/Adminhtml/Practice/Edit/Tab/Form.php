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


        if(Mage::getSingleton('adminhtml/session')->getPracticeData())
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getPracticeData());
            Mage::getSingleton('adminhtml/session')->setPracticeData(null);
        } 
        elseif (Mage::registry('practice_data')) 
        {
            $form->setValues(Mage::registry('practice_data')->getData());
        }
        return parent::_prepareForm();
    }
}