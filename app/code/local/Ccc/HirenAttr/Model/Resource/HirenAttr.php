<?php 
class Ccc_HirenAttr_Model_Resource_HirenAttr extends Mage_Eav_Model_Entity_Abstract
{
	const ENTITY = 'hirenAttr';
	public function __construct()
	{
		$this->setType(self::ENTITY)
			 ->setConnection('core_read', 'core_write');
	   parent::__construct();
    }
}