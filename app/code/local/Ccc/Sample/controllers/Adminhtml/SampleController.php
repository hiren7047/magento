<?php
/**
 * 
 */
class Ccc_Sample_Adminhtml_SampleController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sample/sample')
            ->_addBreadcrumb(Mage::helper('sample')->__('SAmple'), Mage::helper('sample')->__('SAmple'))
            ->_addBreadcrumb(Mage::helper('sample')->__('Manage Salesmen'), Mage::helper('sample')->__('Manage Salesmen'))
        ;
        return $this;
    }

	public function indexAction()
	{
		$this->_title($this->__('Sample'))
             ->_title($this->__('Manage Salesmen'));

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('sample/adminhtml_sample', 'sample'));
        $this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

    public function editAction()
    {
        $id = $this->getRequest()->getParam('sample_id');
        $model = Mage::getModel('sample/sample')->load($id);
        $addressModel = Mage::getModel('sample/sample_address')->load($id,'sample_id');
        if ($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
            {
                $model->setData($data);
            }
            Mage::register('sample_data', $model);
            Mage::register('address_data', $addressModel);

            $this->loadLayout();
            $this->_setActiveMenu('sample/sample');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Sample Manager'), Mage::helper('adminhtml')->__('Sample Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Sample News'), Mage::helper('adminhtml')->__('Sample News'));
             
            $this->_addContent($this->getLayout()->createBlock(' sample/adminhtml_sample_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('sample/adminhtml_sample_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sample')->__('Sample does not exist'));
            $this->_redirect('*/*/');
        }
    }
	public function saveAction()
    {
        try {
            $model = Mage::getModel('sample/sample');
            $addressModel = Mage::getModel('sample/sample_address');
            $data = $this->getRequest()->getPost('salesmen');
            $addressData = $this->getRequest()->getPost('address');

            $sampleId = $this->getRequest()->getParam('id');
            if (!$sampleId)
            {
                $model->setData($data)->setId($this->getRequest()->getParam('sample_id'));
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
                if ($sampleId) {
                    $addressModel->load($sampleId,'sample_id');
                }

                $addressModel->setData(array_merge($addressModel->getData(),$addressData));
                $addressModel->sample_id = $model->sample_id;
                $addressModel->save();
            }
            
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('sample')->__('sample was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('sample_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sample')->__('Unable to find sample to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('sample_id') > 0 ) {
            try {
                $model = Mage::getModel('sample/sample');
                 
                $model->setId($this->getRequest()->getParam('sample_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('sample was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('sample_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $salesmenIds = $this->getRequest()->getParam('sample');
        if(!is_array($salesmenIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select sample(s).'));
        } else {
            try {
                $sample = Mage::getModel('sample/sample');
                foreach ($salesmenIds as $sampleId) {
                    $sample->reset()
                        ->load($sampleId)
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
