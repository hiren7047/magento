<?php

class Ccc_Practice_Adminhtml_SevenController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        echo "<pre>";
       $select = Mage::getSingleton('core/resource')->getConnection('core_read');
       print_r(get_class_methods($select));
    }
    

    

}
