<?php

class Ccc_Product_Model_Practice extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('practice/practice');
    }

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;

        return $this;
    }
}
