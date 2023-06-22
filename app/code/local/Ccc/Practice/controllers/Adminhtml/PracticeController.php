<?php
/**
 * 
 */
class Ccc_Practice_Adminhtml_PracticeController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('practice/practice')
            ->_addBreadcrumb(Mage::helper('practice')->__('PRACTICE'), Mage::helper('practice')->__('PRACTICE'))
            ->_addBreadcrumb(Mage::helper('practice')->__('Manage Practices'), Mage::helper('practice')->__('Manage Practices'))
        ;
        return $this;
    }

	public function indexAction()
	{
		$this->_title($this->__('practice'))
             ->_title($this->__('Manage Practices'));

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_practice', 'practice'));
        $this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

    public function editAction()
    {
        $id = $this->getRequest()->getParam('practice_id');
        $model = Mage::getModel('practice/practice')->load($id);
        if ($model->getId() || $id == 0)
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
            {
                $model->setData($data);
            }
            Mage::register('practice_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('practice/practice');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Practice Manager'), Mage::helper('adminhtml')->__('Practice Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Practice News'), Mage::helper('adminhtml')->__('Practice News'));
             
            $this->_addContent($this->getLayout()->createBlock('practice/adminhtml_practice_edit'))
                    ->_addLeft($this->getLayout()
                    ->createBlock('practice/adminhtml_practice_edit_tabs'));
            $this->renderLayout();
        }else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice')->__('practice does not exist'));
            $this->_redirect('*/*/');
        }
    }
	public function saveAction()
    {
        try {
            $model = Mage::getModel('practice/practice');
            $data = $this->getRequest()->getPost();
            if (!$this->getRequest()->getParam('id'))
            {
                $model->setData($data)->setId($this->getRequest()->getParam('practice_id'));
            }

            $model->setData($data)->setId($this->getRequest()->getParam('id'));
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
             
            Mage::dispatchEvent('cms_page_prepare_save', array('page' => $model, 'request' => $this->getRequest()));
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('practice')->__('practice was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('practice_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('practice')->__('Unable to find practice to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('practice_id') > 0 ) {
            try {
                $model = Mage::getModel('practice/practice');
                 
                $model->setId($this->getRequest()->getParam('practice_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('practice was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('practice_id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $practicesIds = $this->getRequest()->getParam('practice');
        if(!is_array($practicesIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select practice(s).'));
        } else {
            try {
                $practice = Mage::getModel('practice/practice');
                foreach ($practicesIds as $practiceId) {
                    $practice->reset()
                        ->load($practiceId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($practicesIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}
