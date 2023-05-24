<?php 

class Ccc_HirenAttr_Adminhtml_HirenAttrController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction(){
		$this->loadLayout();
		$this->_setActiveMenu('hirenAttr');
		$this->_title('HirenAttr Grid');
		$this->_addContent($this->getLayout()->createBlock('hirenAttr/adminhtml_hirenAttr'));
		$this->renderLayout();
	}

	protected function _initHirenAttr()
    {
        $this->_title($this->__('HirenAttr'))
            ->_title($this->__('Manage HirenAttrs'));

        $hirenAttrId = (int) $this->getRequest()->getParam('id');
        $hirenAttr   = Mage::getModel('hirenAttr/hirenAttr')
            ->setStoreId($this->getRequest()->getParam('store', 0))
            ->load($hirenAttrId);

        if (!$hirenAttrId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $hirenAttr->setAttributeSetId($setId);
            }
        }

        Mage::register('current_hirenAttr', $hirenAttr);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $hirenAttr;
    }

	public function newAction(){
		$this->_forward('edit');
	}

	public function editAction(){ 
		$hirenAttrId = (int) $this->getRequest()->getParam('id');
        $hirenAttr   = $this->_initHirenAttr();
        
        if ($hirenAttrId && !$hirenAttr->getId()) {
            $this->_getSession()->addError(Mage::helper('hirenAttr')->__('This hirenAttr no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        $this->_title($hirenAttr->getName());

        $this->loadLayout();

        $this->_setActiveMenu('hirenAttr/hirenAttr');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();
	}

	public function saveAction()
    {
        try {
            $setId = (int) $this->getRequest()->getParam('set');
            $hirenAttrData = $this->getRequest()->getPost('account');            
            $hirenAttr = Mage::getSingleton('hirenAttr/hirenAttr');
            $hirenAttr->setAttributeSetId($setId);

            if ($hirenAttrId = $this->getRequest()->getParam('id')) {
                if (!$hirenAttr->load($hirenAttrId)) {
                    throw new Exception("No Row Found");
                }
                Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
            }
            
            $hirenAttr->addData($hirenAttrData);

            $hirenAttr->save();

            Mage::getSingleton('core/session')->addSuccess("hirenAttr data added.");
            $this->_redirect('*/*/');

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
        try {

            $hirenAttrModel = Mage::getModel('hirenAttr/hirenAttr');

            if (!($hirenAttrId = (int) $this->getRequest()->getParam('id')))
                throw new Exception('Id not found');

            if (!$hirenAttrModel->load($hirenAttrId)) {
                throw new Exception('hirenAttr does not exist');
            }

            if (!$hirenAttrModel->delete()) {
                throw new Exception('Error in delete record', 1);
            }

            Mage::getSingleton('core/session')->addSuccess($this->__('The hirenAttr has been deleted.'));

        } catch (Exception $e) {
            Mage::logException($e);
            $Mage::getSingleton('core/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*/');
    }
}