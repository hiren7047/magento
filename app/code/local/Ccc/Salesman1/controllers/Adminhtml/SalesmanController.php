<?php
/**
 * 
 */
class Ccc_Salesman_Adminhtml_SalesmanController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('salesman/salesman')
            ->_addBreadcrumb(Mage::helper('salesman')->__('SALESMAN'), Mage::helper('salesman')->__('SALESMAN'))
            ->_addBreadcrumb(Mage::helper('salesman')->__('Manage Salesmen'), Mage::helper('salesman')->__('Manage Salesmen'))
        ;
        return $this;
    }

	public function indexAction()
	{
		$this->_title($this->__('Salesman'))
             ->_title($this->__('Manage Salesmen'));

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('salesman/adminhtml_salesman', 'salesman'));
        $this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

    public function editAction()
    {
        $id = $this->getRequest()->getParam('salesman_id');
        $model = Mage::getModel('salesman/salesman')->load($id);
        $addressModel = Mage::getModel('salesman/salesman_address')->load($id,'salesman_id');
        if ($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
            {
                $model->setData($data);
            }
            Mage::register('salesman_data', $model);
            Mage::register('address_data', $addressModel);

            $this->loadLayout();
            $this->_setActiveMenu('salesman/salesman');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Salesman Manager'), Mage::helper('adminhtml')->__('Salesman Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Salesman News'), Mage::helper('adminhtml')->__('Salesman News'));
             
            $this->_addContent($this->getLayout()->createBlock(' salesman/adminhtml_salesman_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('salesman/adminhtml_salesman_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('Salesman does not exist'));
            $this->_redirect('*/*/');
        }
    }
	public function saveAction()
    {
        try {
            $model = Mage::getModel('salesman/salesman');
            $addressModel = Mage::getModel('salesman/salesman_address');
            $data = $this->getRequest()->getPost('salesmen');
            $addressData = $this->getRequest()->getPost('address');

            $salesmanId = $this->getRequest()->getParam('id');
            if (!$salesmanId)
            {
                $model->setData($data)->setId($this->getRequest()->getParam('salesman_id'));
            }

            $model->setData($data)->setId($this->getRequest()->getParam('id'));
            if ($model->getCreatedTime() == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }

            $model->save();
            if ($model->save()) {
                if ($salesmanId) {
                    $addressModel->load($salesmanId,'salesman_id');
                }

                $addressModel->setData(array_merge($addressModel->getData(),$addressData));
                $addressModel->salesman_id = $model->salesman_id;
                $addressModel->save();
            }
            
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('salesman')->__('salesman was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('salesman_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('salesman')->__('Unable to find salesman to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('salesman_id') > 0 ) {
            try {
                $model = Mage::getModel('salesman/salesman');
                 
                $model->setId($this->getRequest()->getParam('salesman_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('salesman was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('salesman_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $salesmenIds = $this->getRequest()->getParam('salesman');
        if(!is_array($salesmenIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select salesman(s).'));
        } else {
            try {
                $salesman = Mage::getModel('salesman/salesman');
                foreach ($salesmenIds as $salesmanId) {
                    $salesman->reset()
                        ->load($salesmanId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($salesmenIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }

    public function massUpdateAction()
    {
        echo 111;
        echo "<pre>";
        print_r($_POST);
    }
}
