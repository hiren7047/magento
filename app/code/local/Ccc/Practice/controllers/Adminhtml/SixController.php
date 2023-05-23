<?php

class Ccc_Practice_Adminhtml_SixController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
      //How to prepare queries based on SQL SELECT class and fetch records in object format and array format?
                echo "<pre>";
        // create an instance of the SQL SELECT class
        $select = Mage::getSingleton('core/resource')->getConnection('core_read')->select();
        // define the query using the SQL SELECT class methods
        $select->from('product', array('sku', 'cost', 'price'))
               ->limit(10);

        // execute the query and fetch the records as an array
        $recordsArray = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($select);

        // execute the query and fetch the records as an object
        $recordsObject = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($select, array(), Zend_Db::FETCH_OBJ);
        print_r($recordsObject);
        
    }
    

    

}
