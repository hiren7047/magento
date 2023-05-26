<?php

class Hk_Brand_Model_Observer extends Varien_Event_Observer
{

	public function customObserver($observer)
    {
        $form = $observer->getEvent()->getForm();
        $fieldset = $form->addFieldset('group_fields' . 1, array(
            'legend' => Mage::helper('catalog')->__('General'),
            'class' => 'fieldset-wide'
        ));
        $collection = Mage::getModel('brand/brand')->getCollection()->getItems();
        foreach($collection as $c){
            $options[$c->brand_id] = $c->name ; 
        }
        $fieldset->addField('brand', 'select', array(
        'label' => Mage::helper('vendor')->__('Brand'),
        'required' => false,
        'name' => 'brand',
        'values'=> $options,
        ));
    }
}