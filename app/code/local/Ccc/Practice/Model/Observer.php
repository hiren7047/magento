<?php

class Ccc_Practice_Model_Observer extends Varien_Event_Observer
{
	public function __construct()
	{
	}
	public function customObserver($observer)
	{
		echo "String";die;	
	}
}