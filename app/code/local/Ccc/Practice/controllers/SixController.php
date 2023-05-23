<?php
/**
 * 
 */
class Ccc_Practice_SixController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		echo "<pre>";
		// 6.How to prepare queries based on SQL SELECT class and fetch records in object format and array format?

		// create instance of the SQL SELECT class
		$select = Mage::getSingleton('core/resource')->getConnection('core_read')->select();

		// define the query
		echo $select->from('practice', array('practice_id', 'name'))
		       ->where('name = ?', 'yash')
		       ->order('practice_id DESC');

		// execute and fetch
		$recordsArray = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($select);
		       print_r($recordsArray);

		// execute and fetch
		$recordsObject = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchAll($select, array(), Zend_Db::FETCH_OBJ);
		       print_r($recordsObject);
		       die();
	}
}