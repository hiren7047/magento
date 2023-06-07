<?php

class Hk_Brand_Block_Adminhtml_Brand_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('brand_form',array('legend'=>Mage::helper('brand')->__('Brand Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('brand')->__('Name'),
            'required' => true,
            'name' => 'brand[name]',
        ));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('brand')->__('Image'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'image',
        ));

        $fieldset->addField('banner_image', 'image', array(
            'label' => Mage::helper('brand')->__('Banner Image'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'banner_image',
        ));

        $fieldset->addField('description', 'text', array(
            'label' => Mage::helper('brand')->__('Description'),
            'required' => true,
            'name' => 'brand[description]',
        ));

        $fieldset->addField('status', 'text', array(
            'label' => Mage::helper('brand')->__('Status'),
            'required' => true,
            'name' => 'brand[status]',
        ));

        $fieldset->addField('sort_order', 'text', array(
            'label' => Mage::helper('brand')->__('Sort Order'),
            'required' => true,
            'name' => 'brand[sort_order]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getBrandData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBrandData());
            Mage::getSingleton('adminhtml/session')->setBrandData(null);
        } elseif ( Mage::registry('brand_edit') ) {
            $form->setValues(Mage::registry('brand_edit')->getData());
        }
        return parent::_prepareForm();


    }

}
