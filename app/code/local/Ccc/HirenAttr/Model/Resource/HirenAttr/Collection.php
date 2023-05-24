<?php
class Ccc_HirenAttr_Model_Resource_HirenAttr_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract
{
	public function __construct()
	{
		$this->setEntity('hirenAttr');
		parent::__construct();	
	}
}