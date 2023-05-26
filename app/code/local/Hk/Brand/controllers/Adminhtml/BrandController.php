<?php
class Hk_Brand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
    	$this->_title($this->__('Brand'))
             ->_title($this->__('Manage Brands'));
       	$this->loadLayout();
       	$this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand'));
	   	$this->renderLayout();
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('brand/brand')
            ->_addBreadcrumb(Mage::helper('brand')->__('Brand Manager'), Mage::helper('brand')->__('Brand Manager'))
            ->_addBreadcrumb(Mage::helper('brand')->__('Manage brand'), Mage::helper('brand')->__('Manage brand'))
        ;
        return $this;
    }
    

    public function editAction()
    {
        $this->_title($this->__('Brand'))
             ->_title($this->__('Brands'))
             ->_title($this->__('Edit Brands'));

        $id = $this->getRequest()->getParam('brand_id');
        $model = Mage::getModel('brand/brand');

        if ($id) {
            $model->load($id);
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Brand'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('brand_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('brand')->__('Edit Brand')
                    : Mage::helper('brand')->__('New Brand'),
                $id ? Mage::helper('brand')->__('Edit Brand')
                    : Mage::helper('brand')->__('New Brand'));

        $this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand_edit'))
                ->_addLeft($this->getLayout()->createBlock('brand/adminhtml_brand_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        try {

            $model = Mage::getModel('brand/brand');
            $data = $this->getRequest()->getPost('brand');
            $brandId = $this->getRequest()->getParam('id');
            if (!$brandId)
            {
                $brandId = $this->getRequest()->getParam('brand_id');
            }

            $model->setData($data)->setId($brandId);
            if($model->getId()){
                $model->updated_at = now();
            }
            else{
                $model->created_at = now();
            }
            $model->save();
            if(isset($_FILES['image']['name'])) {
                try {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','png')); // or pdf or anything
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('media') . DS . 'brand' . DS;
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $imagegg = $path.$model->getId().'.'.$ext;
                    if ($uploader->save($path, $model->getId().'.'.$ext)) {
                        $model->image = 'brand/'.$model->getId().'.'.$ext;
                        $model->save();
                    }
                    if($model->getId()){
                            $model->updated_at = now();
                        }
                        else{
                            $model->created_at = now();
                        }
                }catch(Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Brand was successfully saved'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
             
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('brand_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Unable to find brand to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('brand_id') > 0 ) {
            try {
                $model = Mage::getModel('brand/brand');
                 
                $model->setId($this->getRequest()->getParam('brand_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Brand was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('brand_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $brandIds = $this->getRequest()->getParam('brand');
        if(!is_array($brandIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Brand(s).'));
        } else {
            try {
                $brand = Mage::getModel('brand/brand');
                foreach ($brandIds as $brandId) {
                    $brand
                        ->load($brandId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($brandIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}