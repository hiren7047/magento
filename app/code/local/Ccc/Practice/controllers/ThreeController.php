<?php
/**
 * 
 */
class Ccc_Practice_ThreeController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		echo "<pre>";

		$practice = Mage::getModel('practice/practice');
		$data = array(
		    'practice_id' => 2,
		    'name' => 'hello here'
		);
		$row = $practice->setData($data);
		$print = $row->save();
		print_r($print); die();

	}
}