<?php

class Ccc_Product_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Products'))->_title($this->__('Manage Products'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('product/adminhtml_product', 'product')
        );
        $this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('product/product')
            ->_addBreadcrumb(Mage::helper('product')->__('PRODUCT'), Mage::helper('product')->__('PRODUCT'))
            ->_addBreadcrumb(Mage::helper('product')->__('Manage Product'), Mage::helper('product')->__('Manage Product'))
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
        $model = Mage::getModel('product/product')->load($id);
        if ($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
            {
                $model->setData($data);
            }
            Mage::register('product_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('product/product');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Product Manager'), Mage::helper('adminhtml')->__('Product Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Product News'), Mage::helper('adminhtml')->__('Product News'));
             
            $this->_addContent($this->getLayout()->createBlock(' product/adminhtml_product_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('product/adminhtml_product_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('product')->__('Product does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('product/product');
            $data = $this->getRequest()->getPost();
            $model->setData($data)->setId($this->getRequest()->getParam('id'));
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
             
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('product')->__('Product was successfully saved'));
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

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('product')->__('Unable to find product to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('product/product');
                 
                $model->setId($this->getRequest()->getParam('id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Product was successfully deleted'));
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
        $productsIds = $this->getRequest()->getParam('product');
        if(!is_array($productsIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select product(s).'));
        } else {
            try {
                $product = Mage::getModel('product/product');
                foreach ($productsIds as $productId) {
                    $product->reset()
                        ->load($productId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($productsIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

}
