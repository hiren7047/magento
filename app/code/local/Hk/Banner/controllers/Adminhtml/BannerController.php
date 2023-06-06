<?php
class Hk_Banner_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
    	$this->_title($this->__('Banner'))
             ->_title($this->__('Manage Banners'));
       	$this->loadLayout();
       	$this->_addContent($this->getLayout()->createBlock('banner/adminhtml_banner'));
	   	$this->renderLayout();
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('banner/banner')
            ->_addBreadcrumb(Mage::helper('banner')->__('Banner Manager'), Mage::helper('banner')->__('Banner Manager'))
            ->_addBreadcrumb(Mage::helper('banner')->__('Manage banner'), Mage::helper('banner')->__('Manage banner'))
        ;
        return $this;
    }
    

    public function editAction()
    {
        $this->_title($this->__('Banner'))
             ->_title($this->__('Banners'))
             ->_title($this->__('Edit Banners'));

        $id = $this->getRequest()->getParam('banner_id');
        $model = Mage::getModel('banner/banner');

        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('banner')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Banner'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('banner_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('banner')->__('Edit Banner')
                    : Mage::helper('banner')->__('New Banner'),
                $id ? Mage::helper('banner')->__('Edit Banner')
                    : Mage::helper('banner')->__('New Banner'));

        $this->_addContent($this->getLayout()->createBlock('banner/adminhtml_banner_edit'))
                ->_addLeft($this->getLayout()->createBlock('banner/adminhtml_banner_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('banner/banner');
            $data = $this->getRequest()->getPost('banner');
            $bannerId = $this->getRequest()->getParam('id');
            if (!$bannerId)
            {
                $bannerId = $this->getRequest()->getParam('banner_id');
            }

            $model->setData($data)->setId($bannerId);
            if ($model->getCreatedTime == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            }
            $model->save();
            if (!$model->save()) {
                throw new Exception("Banner not saved", 1);
            }


            if(isset($_FILES['image']['name'])) {
                try {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','png')); // or pdf or anything
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('media') . DS . 'banner/original' . DS;
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    if (!$uploader->save($path, $model->getId().'.'.$ext)) {
                        throw new Exception("Image Not saved", 1);
                    }

                    $resizedPath = Mage::getBaseDir('media') . DS . 'banner' . DS . 'resized';
                    $image = new Varien_Image($path . DS . $model->getId().'.'.$ext);
                    $image->constrainOnly(true);
                    $image->keepAspectRatio(true);
                    $image->resize($model->getGroup()->getData('width'),$model->getGroup()->getData('height')); // Adjust the dimensions as per your requirement
                    $image->save($resizedPath . DS . $model->getId().'.'.$ext);
                    $model->image = 'banner/resized/'.$model->getId().'.'.$ext;
                    $model->save();
                }catch(Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }


            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('Banner was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('banner_id')));
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
}