<?php

class Hk_Banner_Model_Banner extends Mage_Core_Model_Abstract
{
    function __construct()
    {
        $this->_init('banner/banner');
    }

    public function getGroup()
    {
        $group = Mage::getModel('banner/bannergroup')->load($this->getData('group_id'));
        return $group;
    }
}
