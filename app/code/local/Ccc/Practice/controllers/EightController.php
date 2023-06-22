<?php
/**
 * 
 */
class Ccc_Practice_EightController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		echo "<pre>";
		// 8. Check all methods available in our resource class and find out how it works in Magento ?

		$resource = Mage::getSingleton('practice/resource_practice');
		print_r(get_class_methods($resource));
	}
}