<?php

class Hk_Eavmgmt_Adminhtml_AttributeController extends Mage_Adminhtml_Controller_Action
{
    protected $_entityTypeId;

	public function indexAction()
	{
		$this->_title($this->__('Manage Attributes'));
		$this->loadLayout();
		$this->_addContent($this->getLayout()->createBlock('eavmgmt/adminhtml_attribute'));
		$this->renderLayout();
	}

    public function exportCsvAction()
    {
        $fileName   = 'attribute_'.gmdate('Ymd_His').'.csv';
        $grid       = $this->getLayout()->createBlock('eavmgmt/adminhtml_attribute_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    public function massExportAction()
    {
        $Ids = $this->getRequest()->getParam('eavmgmt');
        $collection = Mage::getResourceModel('eav/entity_attribute_collection');
        $collection->addFieldToFilter('attribute_id', array('in' => $Ids));
        $fileName   = 'attribute_'.date('Ymd_His').'.csv';
        $grid       = $this->getLayout()->createBlock('eavmgmt/adminhtml_attribute_csv');
        $grid->setCollection($collection);
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
}
