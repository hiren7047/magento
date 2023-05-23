<?php
/**
 * 
 */
class Ccc_Practice_TwoController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		echo "<pre>";


		$resource = Mage::getSingleton('core/resource')->getConnection('core_write');
		$tableName = $resource->getTableName('practice');


		$query = "INSERT INTO {$tableName} (name) VALUES ('fix')";
		$resource->query($query);
		print_r($resource);

	}
}