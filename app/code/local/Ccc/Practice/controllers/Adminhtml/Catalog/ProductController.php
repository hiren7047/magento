<?php
require_once(Mage::getModuleDir('controllers','core_mage_adminhtml').DS.'catalog/ProductController.php');

class Ccc_Practice_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    public function newAction()
    {
        echo "This is new Action override controller";
    }
  
}
