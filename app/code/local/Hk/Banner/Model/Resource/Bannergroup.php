<?php

class Hk_Banner_Model_Resource_Bannergroup extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('banner/bannergroup', 'group_id');
    }  
}