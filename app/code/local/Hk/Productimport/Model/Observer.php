<?php

class Hk_Productimport_Model_Observer extends Varien_Event_Observer
{

	public function customObserver($observer)
    {
        $form = $observer->getEvent()->getForm();
        $fieldset = $form->addFieldset('group_fields' . 1, array(
            'legend' => Mage::helper('catalog')->__('General'),
            'class' => 'fieldset-wide'
        ));
        $collection = Mage::getModel('productimport/productimport')->getCollection()->getItems();
        foreach($collection as $c){
            $options[$c->productimport_id] = $c->name ; 
        }
        $fieldset->addField('productimport', 'select', array(
        'label' => Mage::helper('vendor')->__('Productimport'),
        'required' => false,
        'name' => 'productimport',
        'values'=> $options,
        ));
    }
   
}