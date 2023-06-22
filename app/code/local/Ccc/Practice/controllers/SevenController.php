<?php
/**
 * 
 */
class Ccc_Practice_SevenController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		echo "<pre>";
		// 7. Check all methods available in our adapter class and find out how it works in Magento ?
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
		print_r(get_class_methods($connection));
	}
}