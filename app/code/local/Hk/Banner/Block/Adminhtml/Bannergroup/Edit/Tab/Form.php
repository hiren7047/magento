<?php

class Hk_Banner_Block_Adminhtml_Bannergroup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('banner_form',array('legend'=>Mage::helper('banner')->__('Banner Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('banner')->__('Name'),
            'required' => true,
            'name' => 'banner[name]',
        ));

        $fieldset->addField('group_key', 'text', array(
            'label' => Mage::helper('banner')->__('Group Key'),
            'required' => true,
            'name' => 'banner[group_key]',
        ));

        $fieldset->addField('height', 'text', array(
            'label' => Mage::helper('banner')->__('Height'),
            'required' => true,
            'name' => 'banner[height]',
        ));

        $fieldset->addField('width', 'text', array(
            'label' => Mage::helper('banner')->__('Width'),
            'required' => true,
            'name' => 'banner[width]',
        ));

        if ( Mage::getSingleton('adminhtml/session')->getBannerData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBannerData());
            Mage::getSingleton('adminhtml/session')->setBannerData(null);
        } elseif ( Mage::registry('banner') ) {
            $form->setValues(Mage::registry('banner')->getData());
        }
        return parent::_prepareForm();


    }

}





    