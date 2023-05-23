<?php

class Ccc_Practice_Adminhtml_FiveController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        //How to prepare queries based on collection class and fetch records in object format and array format?
          echo "<pre>";
        // create an instance of the collection class for the table you want to query
        $collection = Mage::getModel('product/product')->getCollection();

        // add filters to the collection as needed
        $collection->addFieldToFilter('status', array('eq' => 1));

        // fetch the records as an array
        $recordsArray = $collection->getData();
        print_r($recordsArray);

        // fetch the records as an object
        $recordsObject = $collection->getItems();
        print_r($recordsObject);
    }
    

    

}
