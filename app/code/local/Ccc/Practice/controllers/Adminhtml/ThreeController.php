<?php

class Ccc_Practice_Adminhtml_ThreeController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $order = Mage::getModel('product/product');

        $data = array(
            'sku' => '54854',
            'price' => 1000,
            'status' => 1,
            // add other fields as needed
        );
        $row = $order->setData($data);
        print_r($row->save());
    }
    

    

}
