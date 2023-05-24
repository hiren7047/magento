<?php

class Ccc_Hiren_Model_Attribute extends Mage_Eav_Model_Attribute
{
    const MODULE_NAME = 'Ccc_Hiren';
    protected $_eventObject = 'attribute';

    protected function _construct()
    {
        $this->_init('hiren/attribute');
    }
}