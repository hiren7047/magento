<?php
/**
 * 
 */
class Ccc_Practice_OneController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		echo "<pre>";
		// print_r(Mage::getModuleDir('controllers','practice'));
		// print_r(Mage::getStoreConfig('catalog'));
		print_r(Mage::getStoreConfig('catalog'));

		echo "<br><br><br>";
		print_r(get_class_methods(new Mage()));
	    die;

	    $collection = Mage::getModel('practice/practice')->getCollection()->toArray();
		$read = Mage::getSingleton('core/resource')->getConnection('core_read');
		$select = $read->select()
		    ->from('practice', array('practice_id', 'name'))
		    ->where('name = ?', 'haze');
		$rows = $read->fetchAll($select);
	    print_r($rows); die;
	}
}