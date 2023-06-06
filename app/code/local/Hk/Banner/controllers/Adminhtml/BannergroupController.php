<?php
class Hk_Banner_Adminhtml_BannergroupController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
    	$this->_title($this->__('Banner'))
             ->_title($this->__('Manage Banners'));
       	$this->loadLayout();
       	$this->_addContent($this->getLayout()->createBlock('banner/adminhtml_bannergroup'));
	   	$this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('banner/banner')
            ->_addBreadcrumb(Mage::helper('banner')->__('Banner Manager'), Mage::helper('banner')->__('Banner Manager'))
            ->_addBreadcrumb(Mage::helper('banner')->__('Manage banner'), Mage::helper('banner')->__('Manage banner'))
        ;
        return $this;
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('group_id');
        $model = Mage::getModel('banner/bannergroup');

        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('banner')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('banner',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('banner')->__('Edit Banner')
                    : Mage::helper('banner')->__('New Banner'),
                $id ? Mage::helper('banner')->__('Edit Banner')
                    : Mage::helper('banner')->__('New Banner'));

        $this->_addContent($this->getLayout()->createBlock('banner/adminhtml_bannergroup_edit'))
                ->_addLeft($this->getLayout()->createBlock('banner/adminhtml_bannergroup_edit_tabs'));

        $this->renderLayout();
    }

    
   public function saveAction()
    {
        try {
            $model = Mage::getModel('banner/bannergroup');
            $data = $this->getRequest()->getPost('banner');
            $bannerGroupId = $this->getRequest()->getParam('group_id');
            if (!$bannerGroupId)
            {
                $bannerGroupId = $this->getRequest()->getParam('banner_id');
            }

            $model->setData($data)->setId($bannerGroupId);
            if ($model->getCreatedTime == NULL)
            {
                $model->setCreatedTime(now());
            }
            $model->save();
            if (!$model->save()) {
                throw new Exception("Banner Group not saved", 1);
            }

            $data = $this->getRequest()->getPost();
            if($data['position'] && $data['status']){
                $positions = $data['position'];
                $statuses = $data['status'];

                foreach ($positions as $bannerId => $position) {
                    $bannerModel = Mage::getModel('banner/banner');
                    $bannerModel->banner_id = $bannerId;
                    $bannerModel->position = $position;
                    $bannerModel->status = $statuses[$bannerId];
                    $bannerModel->save();
                }
            }

            if($remove = $data['remove']){
                foreach ($remove as $id => $value) {
                    $model = Mage::getModel('banner/banner')->load($id);
                    $model->delete();
                }
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('Banner Group was successfully saved'));
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('group_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('Unable to find banner to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('banner_id') > 0 ) {
            try {
                $model = Mage::getModel('banner/banner');
                 
                $model->setId($this->getRequest()->getParam('banner_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Banner was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('banner_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $bannerIds = $this->getRequest()->getParam('banner');
        if(!is_array($bannerIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Banner(s).'));
        } else {
            try {
                $banner = Mage::getModel('banner/banner');
                foreach ($bannerIds as $bannerId) {
                    $banner
                        ->load($bannerId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($bannerIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

   public function uploadAction()
    {
        try {
            $id = $this->getRequest()->getParam('group_id');
            $bannerGroupModel = Mage::getModel('banner/bannergroup')->load($id);
            $width = $bannerGroupModel->width;
            $height = $bannerGroupModel->height;
            
            foreach ($_FILES['file']['tmp_name'] as $index => $tmpName) {
                $uploader = new Mage_Core_Model_File_Uploader('file[' . $index . ']');
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png', 'webp'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);

                $uploadDir = Mage::getBaseDir('media') . DS . 'banner' . DS . 'original';
                $uploadResizedDir = Mage::getBaseDir('media') . DS . 'banner' . DS . 'resized';
                $uploader->save($uploadDir, $images['name'][$index]);

                $uploadedFilePath = $uploadDir . DS . $uploader->getUploadedFileName();
                $resizedFilePath = $uploadResizedDir . DS . $uploader->getUploadedFileName();

                $image = new Varien_Image($uploadedFilePath);
                
                    $image->keepAspectRatio(true);
                    $image->resize($width, $height);
                    $image->save($resizedFilePath);
                    $model = Mage::getModel('banner/banner');
                    $model->setImage('banner'.DS.'resized'.DS.$uploader->getUploadedFileName());
                    $model->group_id = $id;
                    $model->save();
            }
            
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Banner was uploaded.'));

            $this->_redirect('*/*/edit',['group_id'=> $id]);
        } 
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/edit',['group_id'=> $id]);
    }

}