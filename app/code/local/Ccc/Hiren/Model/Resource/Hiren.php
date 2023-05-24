<?php 
class Ccc_Hiren_Model_Resource_Hiren extends Mage_Eav_Model_Entity_Abstract
{
	const ENTITY = 'hiren';
	public function __construct()
	{
		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');
	   parent::__construct();
    }
}