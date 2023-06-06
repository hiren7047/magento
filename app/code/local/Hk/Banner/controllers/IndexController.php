<?php
class Hk_Banner_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
       	$this->loadLayout();
       	// $this->_addContent($this->getLayout()->createBlock('banner/adminhtml_banner'));
	   	$this->renderLayout();
    }
}