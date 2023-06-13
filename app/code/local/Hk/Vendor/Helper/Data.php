<?php

class Hk_Vendor_Helper_Data extends Mage_Core_Helper_Abstract
{
    const ROUTE_ACCOUNT_LOGIN = 'vendor/index/login';
    const REFERER_QUERY_PARAM_NAME = 'referer';

    public function generatePassword($length = 8)
    {
        $chars = Mage_Core_Helper_Data::CHARS_PASSWORD_LOWERS
            . Mage_Core_Helper_Data::CHARS_PASSWORD_UPPERS
            . Mage_Core_Helper_Data::CHARS_PASSWORD_DIGITS
            . Mage_Core_Helper_Data::CHARS_PASSWORD_SPECIALS;
        return Mage::helper('core')->getRandomString($length, $chars);
    }

    public function getRegisterPostUrl()
    {
        return $this->_getUrl('vendor/index/createpost');
    }
    public function getSignupUrl()
    {
        return $this->_getUrl('vendor/index/signupPost');
    }

    public function getLoginUrl()
    {
        return $this->_getUrl(self::ROUTE_ACCOUNT_LOGIN, $this->getLoginUrlParams());
    }

    public function getLoginUrlParams()
    {
        $params = array();

        $referer = $this->_getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME);

        if ($referer) {
            $params = array(self::REFERER_QUERY_PARAM_NAME => $referer);
        }

        return $params;
    }
    public function getLoginPostUrl()
    {
        $params = array();
        if ($this->_getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME)) {
            $params = array(
                self::REFERER_QUERY_PARAM_NAME => $this->_getRequest()->getParam(self::REFERER_QUERY_PARAM_NAME)
            );
        }
        return $this->_getUrl('vendor/index/loginPost', $params);
    }
    public function getForgotPasswordUrl()
    {
        return $this->_getUrl('vendor/index/forgot');
    }
     public function getRegisterUrl()
    {
        return $this->_getUrl('vendor/index/createpost');
    }
    public function getEmailConfirmationUrl($email = null)
    {
        return $this->_getUrl('vendor/index/confirmation', array('email' => $email));
    }
}
