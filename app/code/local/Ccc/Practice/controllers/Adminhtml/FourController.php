<?php

class Ccc_Practice_Adminhtml_FourController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
        //How to insert multiple rows at a time when required to insert multiple rows into a table ? Check the function.
        $connection = Mage::getModel('core/resource')->getConnection('core_write');
        $rows = array(
            array(
                'sku' => 'HP 1400',
                'cost' => 1500,
                'price' => 1600
            ),
            array(
                'sku' => 'HP 1500',
                'cost' => 1500,
                'price' => 1600
            ),
        );
        print_r($connection->insertArray('product', array('sku', 'cost', 'price'), $rows));
    }

}
