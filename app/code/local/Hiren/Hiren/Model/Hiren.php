<?php
/**
 * 
 */
class Hiren_Hiren_Model_Hiren extends Mage_Core_Model_Abstract
{
    const ENTITY = 'hiren';

    protected $_attributes;
    
	protected function _construct()
    {  
        $this->_init('hiren/hiren');
    }

   public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;
        return $this;
    }
}