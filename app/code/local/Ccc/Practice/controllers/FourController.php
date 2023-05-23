<?php
/**
 * 
 */
class Ccc_Practice_FourController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		echo "<pre>";
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		$tableName = $connection->getTableName('practice');
		$rows = array(
		    array(
		        'practice_id' => '11',
		        'name' => 'vishal',
		    ),
		    array(
		        'practice_id' => '12',
		        'name' => 'krushal',
		    ),
		);

		$connection->insertArray($tableName, array('practice_id', 'name', /* add other column names as needed */), $rows);
		print_r($connection); die;
	}
}