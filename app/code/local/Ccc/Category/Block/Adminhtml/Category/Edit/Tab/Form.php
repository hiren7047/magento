<?php

class Ccc_category_Block_Adminhtml_category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('category_form',array('legend'=>Mage::helper('category')->__('category information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('category')->__('Name'),
            'required' => true,
            'name' => 'name',
        ));

        $fieldset->addField('status', 'text', array(
            'label' => Mage::helper('category')->__('Status'),
            'required' => true,
            'name' => 'status',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getcategoryData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getcategoryData());
            Mage::getSingleton('adminhtml/session')->setcategoryData(null);
        } elseif ( Mage::registry('category_edit') ) {
            $form->setValues(Mage::registry('category_edit')->getData());
        }
        return parent::_prepareForm();


    }

}





    