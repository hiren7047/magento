<?php

class Ccc_HirenAttr_Model_Attribute extends Mage_Eav_Model_Attribute
{
    const MODULE_NAME = 'Ccc_HirenAttr';
    protected $_eventObject = 'attribute';

    protected function _construct()
    {
        $this->_init('hirenAttr/attribute');
    }
}