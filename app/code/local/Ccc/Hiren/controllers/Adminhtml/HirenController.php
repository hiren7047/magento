<?php 

class Ccc_Hiren_Adminhtml_HirenController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction(){
		$this->loadLayout();
		$this->_setActiveMenu('hiren');
		$this->_title('Hiren Grid');
		$this->_addContent($this->getLayout()->createBlock('hiren/adminhtml_hiren'));
		$this->renderLayout();
	}

	protected function _initHiren()
    {
        $this->_title($this->__('Hiren'))
            ->_title($this->__('Manage Hirens'));

        $hirenId = (int) $this->getRequest()->getParam('id');
        $hiren   = Mage::getModel('hiren/hiren')
            ->setStoreId($this->getRequest()->getParam('store', 0))
            ->load($hirenId);

        if (!$hirenId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $hiren->setAttributeSetId($setId);
            }
        }

        Mage::register('current_hiren', $hiren);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $hiren;
    }

	public function newAction(){
		$this->_forward('edit');
	}

	public function editAction(){ 
		$hirenId = (int) $this->getRequest()->getParam('id');
        $hiren   = $this->_initHiren();
        
        if ($hirenId && !$hiren->getId()) {
            $this->_getSession()->addError(Mage::helper('hiren')->__('This hiren no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($hiren->getName());

        $this->loadLayout();

        $this->_setActiveMenu('hiren/hiren');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();
	}

	public function saveAction()
    {
        try {
            $setId = (int) $this->getRequest()->getParam('set');
            $hirenData = $this->getRequest()->getPost('account');            
            $hiren = Mage::getSingleton('hiren/hiren');
            $hiren->setAttributeSetId($setId);

            if ($hirenId = $this->getRequest()->getParam('id')) {
                if (!$hiren->load($hirenId)) {
                    throw new Exception("No Row Found");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            }
            
            $hiren->addData($hirenData);

            $hiren->save();

            Mage::getSingleton('core/session')->addSuccess("hiren data added.");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {

            $hirenModel = Mage::getModel('hiren/hiren');

            if (!($hirenId = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$hirenModel->load($hirenId)) {
                throw new Exception('hiren does not exist');
            }

            if (!$hirenModel->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The hiren has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            $Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    }
}