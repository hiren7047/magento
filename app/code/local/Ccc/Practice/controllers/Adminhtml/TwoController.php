<?php

class Ccc_Practice_Adminhtml_TwoController extends Mage_Adminhtml_Controller_Action
{
    //How to insert a single row into a table using a query string ?
    public function indexAction()
    {  
    $resource = Mage::getSingleton('core/resource');
    $writeConnection = $resource->getConnection('core_write');
    $tableName = $resource->getTableName('product');

    $query = "INSERT INTO `product`(`product_id`, `name`, `sku`, `price`, `cost`, `quantity`, `description`, `status`, `created_time`, `update_time`) VALUES ('[value-1]','[value-2]','[fec-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')";
//    die;
    $writeConnection->query($query);
    }
    

    

}
