<?php
/**
 * 
 */
class Hiren_Hiren_Adminhtml_HirenController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('hiren/hiren')
            ->_addBreadcrumb(Mage::helper('hiren')->__('Hiren'), Mage::helper('hiren')->__('Hiren'))
            ->_addBreadcrumb(Mage::helper('hiren')->__('Manage Salesmen'), Mage::helper('hiren')->__('Manage'))
        ;
        return $this;
    }

	public function indexAction()
	{
		$this->_title($this->__('Sample'))
             ->_title($this->__('Manage'));

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('hiren/adminhtml_hiren', 'hiren'));
        $this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('hiren/hiren')->load($id);
        $addressModel = Mage::getModel('hiren/hiren_address')->load($id,'id');
        if ($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
            {
                $model->setData($data);
            }
            Mage::register('hiren_data', $model);
            Mage::register('address_data', $addressModel);

            $this->loadLayout();
            $this->_setActiveMenu('hiren/hiren');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Manager'), Mage::helper('adminhtml')->__('Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('News'), Mage::helper('adminhtml')->__('News'));
             
            $this->_addContent($this->getLayout()->createBlock(' hiren/adminhtml_hiren_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('hiren/adminhtml_hiren_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hiren')->__('Sample does not exist'));
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
