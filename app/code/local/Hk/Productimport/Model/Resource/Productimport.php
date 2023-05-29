<?php

class Hk_Productimport_Model_Resource_Productimport extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('productimport/productimport', 'index');
    }  
}