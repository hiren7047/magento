<?php
class Hk_Vendor_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // $this->loadLayout();
        // $this->renderLayout();
        echo $this->_prepareBodyContent(19);
    }

    public function registerAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function signupAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function signupPostAction()
{
    if ($this->getRequest()->isPost()) {
        // Retrieve the posted data
        $postData = $this->getRequest()->getPost('vendor');

        if (!$postData) {
            $this->_redirect('*/*/register');
            return;
        }

        $errors = array();

        // Validate the posted data
        $validationResult = $this->_validateRegistrationData($postData);
        if ($validationResult !== true) {
            $errors = $validationResult;
        } else {
            $vendor = Mage::getModel('vendor/vendor');
            $vendor->load($postData['email'], 'email'); // Check if the email is already registered as a vendor
            if ($vendor->getId()) {
                $errors[] = 'Email address is already registered as a vendor.';
            } else {
                try {
                    // Create the vendor record
                    $vendor->setData('first_name', $postData['fname']);
                    $vendor->setData('last_name', $postData['lname']);
                    $vendor->setData('email', $postData['email']);
                    $vendor->setData('company', $postData['company']);
                    $vendor->setData('mobile', $postData['telephone']);
                    $vendor->setData('password', $postData['password']);
                    $vendor->setData('created_at', now());
                    $vendor->setData('status', 0);

                    $vendorId = $vendor->save();
                     $vendorId = $vendor->getId();
                    $vendor = Mage::getModel('vendor/vendor')->load($vendorId);
                    $content = $this->_prepareBodyContent($vendorId);
                    $this->_sendmail($vendor ,$content);
                    // Perform additional vendor registration tasks if needed

                    // Redirect to a success page or perform any other desired action
                    Mage::getSingleton('core/session')->addSuccess('Vendor registration successful.And verify the mail '.$postData['email']);
                    $this->_redirect('*/*/register');
                    return;
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
        }

        // If there are errors, display them and redirect back to the registration form
        Mage::getSingleton('core/session')->setVendorFormData($postData);
        Mage::getSingleton('core/session')->addError(implode('<br>', $errors));
        $this->_redirect('*/*/signup');
    } else {
        Mage::getSingleton('core/session')->addError("Error: Request is not allowed.");
        // Redirect the user to another page or display the error message as needed
        $this->_redirect('*/index/register');
    }
}
    public function _prepareBodyContent($id)
    {
        $encryptionKey = 'cybercom'; // Replace with your encryption key
        $hashKey = base64_encode(openssl_encrypt($id, 'AES-256-CBC', $encryptionKey, 0, substr(md5($encryptionKey), 0, 16)));

        $mailUrl = Mage::getUrl('*/*/urlVerification');
        $finalUrl = $mailUrl .'key/'.$hashKey;

        $content = 'please verify the user via this url '.$finalUrl;
        return $content;
    }
   public function urlVerificationAction()
{
    try {
        $hashKey = $this->getRequest()->getParam('key');
        if (!$hashKey) {
            Mage::throwException('Invalid URL. Please verify the mail URL.');
        }

        $encryptionKey = 'cybercom'; // Replace with your encryption key
        $vendorId = openssl_decrypt(base64_decode($hashKey), 'AES-256-CBC', $encryptionKey, 0, substr(md5($encryptionKey), 0, 16));
        $vendorModel = Mage::getModel('vendor/vendor')->load($vendorId);
        if (!$vendorModel->getId()) {
            Mage::throwException('Invalid records found. Please contact the admin.');
        }

        $vendorModel->setStatus(1);
        $vendorModel->save();

        Mage::getSingleton('core/session')->addSuccess('Vendor verification successful. Please login.');
        $this->_redirect('*/*/register');
    } catch (Exception $e) {
        Mage::getSingleton('core/session')->addError($e->getMessage());
        $this->_redirect('*/*/register');
    }
}



    public function createPostAction()
    {
        echo "<pre>";
        print_r($_POST);
        die;
        $errUrl = $this->_getUrl('*/*/create', array('_secure' => true));

        if (!$this->_validateFormKey()) {
            $this->_redirectError($errUrl);
            return;
        }

        /** @var $session Mage_Vendor_Model_Session */
        $session = $this->_getSession();
        if ($session->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }

        if (!$this->getRequest()->isPost()) {
            $this->_redirectError($errUrl);
            return;
        }

        $vendor = $this->_getVendor();

        try {
            $errors = $this->_getVendorErrors($vendor);

            if (empty($errors)) {
                $vendor->cleanPasswordsValidationData();
                $vendor->setPasswordCreatedAt(time());
                $vendor->save();
                $this->_dispatchRegisterSuccess($vendor);
                $this->_successProcessRegistration($vendor);
                return;
            } else {
                $this->_addSessionError($errors);
            }
        } catch (Mage_Core_Exception $e) {
            $session->setVendorFormData($this->getRequest()->getPost());
            if ($e->getCode() === Mage_Vendor_Model_Vendor::EXCEPTION_EMAIL_EXISTS) {
                $url = $this->_getUrl('vendor/account/forgotpassword');
                $message = $this->__('There is already an account with this email address. If you are sure that it is your email address, <a href="%s">click here</a> to get your password and access your account.', $url);
            } else {
                $message = $this->_escapeHtml($e->getMessage());
            }
            $session->addError($message);
        } catch (Exception $e) {
            $session->setVendorFormData($this->getRequest()->getPost());
            $session->addException($e, $this->__('Cannot save the vendor.'));
        }

        $this->_redirectError($errUrl);
    }

    protected function _getVendor()
    {
        $vendor = $this->_getFromRegistry('current_vedor');
        if (!$vendor) {
            $vendor = $this->_getModel('vendor/vendor')->setId(null);
        }
        if ($this->getRequest()->getParam('is_subscribed', false)) {
            $vendor->setIsSubscribed(1);
        }
        $vendor->getGroupId();

        return $vendor;
    }

    protected function _getVendorErrors($vendor)
    {
        $errors = array();
        $request = $this->getRequest();
        if ($request->getPost('create_address')) {
            $errors = $this->_getErrorsOnVendorAddress($vendor);
        }
        $vendorForm = $this->_getVendorForm($vendor);
        $vendorData = $vendorForm->extractData($request);
        $vendorErrors = $vendorForm->validateData($vendorData);
        if ($vendorErrors !== true) {
            $errors = array_merge($vendorErrors, $errors);
        } else {
            $vendorForm->compactData($vendorData);
            $vendor->setPassword($request->getPost('password'));
            $vendor->setPasswordConfirmation($request->getPost('confirmation'));
            $vendorErrors = $vendor->validate();
            if (is_array($vendorErrors)) {
                $errors = array_merge($vendorErrors, $errors);
            }
        }
        return $errors;
    }
    protected function _getUrl($url, $params = array())
    {
        return Mage::getUrl($url, $params);
    }

     protected function _getSession()
    {
        print_r(Mage::getSingleton('vendor/session'));
        die;
        return Mage::getSingleton('vendor/session');
    }

    protected function _getFromRegistry($path)
    {
        return Mage::registry($path);
    }
    public function _getModel($path, $arguments = array())
    {
        return Mage::getModel($path, $arguments);
    }
    protected function _getVendorForm($vendor)
    {
        /* @var $vendorForm Mage_Customer_Model_Form */
        $vendorForm = $this->_getModel('vendor/form');
        $vendorForm->setFormCode('vendor_account_create');
        $vendorForm->setEntity($vendor);
        return $vendorForm;
    }

   protected function _validateRegistrationData($data)
{
    $errors = array();

    // Validate name
    if (empty($data['fname'])) {
        $errors[] = 'Please enter your name.';
    }

    // Validate email
    if (empty($data['email'])) {
        $errors[] = 'Please enter your email address.';
    } elseif (!Zend_Validate::is($data['email'], 'EmailAddress')) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Validate company
    if (empty($data['company'])) {
        $errors[] = 'Please enter your company name.';
    }

    // Validate telephone (mobile number)
    if (empty($data['telephone'])) {
        $errors[] = 'Please enter your mobile number.';
    } else {
        // Custom mobile number validation rule
        $mobileRegex = '/^[0-9]{10}$/'; // Assuming a 10-digit mobile number is required
        if (!preg_match($mobileRegex, $data['telephone'])) {
            $errors[] = 'Please enter a valid 10-digit mobile number.';
        }
    }

    // Validate password
    if (empty($data['password'])) {
        $errors[] = 'Please enter a password.';
    }

    // Validate password confirmation
    if ($data['password'] !== $data['confirmation']) {
        $errors[] = 'Password confirmation does not match.';
    }

    if (!empty($errors)) {
        return $errors;
    }

    return true;
}

    public function _sendmail($model , $content)
    {
       $vendor = $model;
            $email = $vendor->getEmail();
            $vars = array(
                'vendor' => $vendor,
                'message' => 'Hello vendor, hope you have a good day!',
            );

            $emailTemplate = Mage::getModel('core/email_template')->loadDefault('vendor_login_email_template');

            $processedTemplate = $emailTemplate->getProcessedTemplate($vars);

            $config = array(
                'ssl' => 'tls',
                'port' => 587,
                'auth' => 'login',
                'username' => 'hirenkhunt.ccc@gmail.com', // Replace with your Gmail email address
                'password' => 'bjsoarxqdfheivyq', // Replace with your Gmail password or app password
            );

            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);

            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyHtml($content);
            $mail->setfrom('hirenkhunt.ccc@gmail.com', 'Heric'); // Replace with your Gmail email address and name
            $mail->addTo($email, 'Vendor');
            $mail->setSubject('Welcome Vendor');
            $mail->setBodyText('Hello vendor, hope you have a good day!');

            // echo "<pre>";
            // print_r($emailTemplate);
            // die;
            $mail->send($transport);
            return true;
    }


}