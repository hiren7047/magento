<?php

class Hk_Banner_Model_Resource_Banner extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('banner/banner', 'banner_id');
    }  
}