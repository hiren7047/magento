<?php
class Hk_Banner_Model_Resource_Bannergroup_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('banner/bannergroup');
    }
}