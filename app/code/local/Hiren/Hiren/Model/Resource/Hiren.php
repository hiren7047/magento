<?php

class Hiren_Hiren_Model_Resource_Hiren extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('hiren/hiren', 'id');
    }
}
