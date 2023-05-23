<?php
/**
 * 
 */
class Ccc_Sample_Model_Sample extends Mage_Core_Model_Abstract
{
    protected $_attributes;
    
	protected function _construct()
    {  
        $this->_init('sample/sample');
    }

   public function reset()
    {
        $this->setData(array());
        $this->setOrigData();
        $this->_attributes = null;
        return $this;
    }
}