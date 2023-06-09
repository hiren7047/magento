<?php
/**
 * 
 */
class Ccc_Practice_FiveController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		echo "<pre>";
		// 5. How to prepare queries based on collection class and fetch records in object format and array format?

		$collection = Mage::getModel('practice/practice')->getCollection();

		// add filters
		$collection->addFieldToFilter('name', array('eq' => 1));

		// records as an array
		$recordsArray = $collection->getData();
		print_r($recordsArray); die;

		// records as an object
		$recordsObject = $collection->getItems();
	}
}