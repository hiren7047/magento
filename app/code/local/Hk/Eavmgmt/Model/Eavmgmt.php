<?php
/**
 * 
 */
class Hk_Eavmgmt_Model_Eavmgmt extends Mage_Core_Model_Abstract
{
    protected $_attributes;
    const ENTITY = 'nikunj';
    
	protected function _construct()
    {  
        $this->_init('eavmgmt/eavmgmt');
    }

    public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;
        return $this;
    }
}