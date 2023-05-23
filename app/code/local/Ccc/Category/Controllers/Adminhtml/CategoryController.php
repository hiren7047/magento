<?php

class Ccc_Category_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Category'))->_title($this->__('Manage Category'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('category/adminhtml_category', 'category')
        );
        $this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('vendor/vendor')
            ->_addBreadcrumb(Mage::helper('vendor')->__('VENDOR'), Mage::helper('vendor')->__('VENDOR'))
            ->_addBreadcrumb(Mage::helper('vendor')->__('Manage Vendor'), Mage::helper('vendor')->__('Manage Vendor'))
        ;
        return $this;
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('category/category')->load($id);
        if ($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
            {
                $model->setData($data);
            }
            Mage::register('category_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('category/category');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Category Manager'), Mage::helper('adminhtml')->__('Category Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Category News'), Mage::helper('adminhtml')->__('Category News'));
             
            $this->_addContent($this->getLayout()->createBlock(' category/adminhtml_category_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('category/adminhtml_category_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('category')->__('Category does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('category/category');
            $data = $this->getRequest()->getPost();
            if (!$this->getRequest()->getParam('id'))
            {
                $model->setData($data)->setId($this->getRequest()->getParam('category_id'));
            }

            $model->setData($data)->setId($this->getRequest()->getParam('id'));
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('category')->__('Category was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('category')->__('Unable to find category to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('category/category');
                 
                $model->setId($this->getRequest()->getParam('id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Category was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $categoryIds = $this->getRequest()->getParam('category');
        if(!is_array($categoryIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select category(s).'));
        } else {
            try {
                $category = Mage::getModel('category/category');
                foreach ($categoryIds as $categoryId) {
                    $category->reset()
                        ->load($categoryId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($categoryIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

}
