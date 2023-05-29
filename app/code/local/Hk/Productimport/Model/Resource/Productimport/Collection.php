<?php
class Hk_Productimport_Model_Resource_Productimport_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('productimport/productimport');
    }
}