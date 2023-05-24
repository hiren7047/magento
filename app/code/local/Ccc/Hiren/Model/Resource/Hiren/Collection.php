<?php
class Ccc_Hiren_Model_Resource_Hiren_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract
{
	public function __construct()
	{
		$this->setEntity('hiren');
		parent::__construct();	
	}
}