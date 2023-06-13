<?php

class Hk_Vendor_Block_Signup extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSignupActionUrl()
    {
        return $this->helper('vendor')->getSignupUrl();
    }
}