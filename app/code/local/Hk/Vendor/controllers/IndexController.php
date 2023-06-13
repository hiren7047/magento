<?php
class Hk_Vendor_IndexController extends Mage_Core_Controller_Front_Action
{
    public function loginAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function loginPostAction()
    {
        try {
            $session = Mage::getSingleton('core/session');
            if (!$session) {
                throw new Exception("Session not found.", 1);
                exit;
            }

            $loginCredentials = $this->getRequest()->getPost('login');

            if (empty($loginCredentials['username']) || empty($loginCredentials['password'])) {
                throw new Exception("Please enter email and password.", 1);
            }

            $model = Mage::getModel('vendor/vendor')->load($loginCredentials['username'], 'email');

            if (!$model->getId()) {
                throw new Exception("Wrong email or password.", 1);
            }

            if ($model->getStatus() != 1) {
                $value = Mage::helper('vendor')->getEmailConfirmationUrl($loginCredentials['username']);
                $message = Mage::helper('vendor')->__('This account is not confirmed. <a href="%s">Click here</a> to resend the confirmation email.', $value);
                $session->addError($message);
                $this->_redirect('*/*/login');
                return;
            }

            $session->setVendorData($model);

            $this->_redirect('*/*/index');
            return;
        } catch (Exception $e) {
            $session->addError($e->getMessage());
            $this->_redirect('*/*/login');
            return;
        }
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
                $this->_redirect('*/*/login');
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
                        $this->_sendmail($vendor, $content);

                        Mage::getSingleton('core/session')->addSuccess('Vendor registration successful. Please verify the email ' . $postData['email']);
                        $this->_redirect('*/*/login');
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
            $this->_redirect('*/index/login');
        }
    }

    public function _prepareBodyContent($id)
    {
        $encryptionKey = 'cybercom'; // Replace with your encryption key
        $hashKey = base64_encode(openssl_encrypt($id, 'AES-256-CBC', $encryptionKey, 0, substr(md5($encryptionKey), 0, 16)));

        $mailUrl = Mage::getUrl('*/*/urlVerification');
        $finalUrl = $mailUrl . 'key/' . $hashKey;

        $content = 'please verify the user via this URL ' . $finalUrl;
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

            if ($vendorModel->getStatus() == 1) {
                Mage::getSingleton('core/session')->addSuccess('Vendor already verified. Please login.');
                $this->_redirect('*/*/login');
            } else {
                $vendorModel->setStatus(1);
                $vendorModel->save();
                Mage::getSingleton('core/session')->addSuccess('Vendor verification successful. Please login.');
                $this->_redirect('*/*/login');
            }
        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/login');
        }
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

    protected function _getUrl($url, $params = array())
    {
        return Mage::getUrl($url, $params);
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

        if (empty($data['fname'])) {
            $errors[] = 'Please enter your name.';
        }

        if (empty($data['email'])) {
            $errors[] = 'Please enter your email address.';
        } elseif (!Zend_Validate::is($data['email'], 'EmailAddress')) {
            $errors[] = 'Please enter a valid email address.';
        }

        if (empty($data['company'])) {
            $errors[] = 'Please enter your company name.';
        }

        if (empty($data['telephone'])) {
            $errors[] = 'Please enter your mobile number.';
        } else {
            $mobileRegex = '/^[0-9]{10}$/'; // Assuming a 10-digit mobile number is required

            if (!preg_match($mobileRegex, $data['telephone'])) {
                $errors[] = 'Please enter a valid 10-digit mobile number.';
            }
        }

        if (empty($data['password'])) {
            $errors[] = 'Please enter a password.';
        }

        if ($data['password'] !== $data['confirmation']) {
            $errors[] = 'Password confirmation does not match.';
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

    public function _sendmail($model, $content)
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
        $mail->send($transport);
        return true;
    }

    public function forgotAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
