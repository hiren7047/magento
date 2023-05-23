<?php

class Ccc_Practice_Adminhtml_OneController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        //1. How you will prepare different types of queries and take a collection of rows in  object format and array format.
        $collection = Mage::getModel('product/product')->getCollection()->toArray();
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $read->select()
            ->from('product',array('sku', 'price'))
            ->where('status = ?',1);
//        $rows = $collection->getData();
//        $rows = $collection->getItems();
        $rows = $read->fetchAll($select);

        echo '<pre>';
        print_r($rows);
    }
    

    

}
