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

    public function newAction()
    {
         $this->_title($this->__('Attributes'))
             ->_title($this->__('import Options'));
            $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('eavmgmt/adminhtml_attribute_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('eavmgmt/adminhtml_attribute_edit_tabs'));
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

    public function optionAction()
    {
        $this->_title($this->__('Manage Option'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('eavmgmt/adminhtml_attribute_option'));
        $this->renderLayout();
        
    }
 public function massExportOptionsAction()
    {
        $attributes = $this->getRequest()->getPost('eavmgmt');
        $fileName   ='attributeoptions_'.date('Ymd_His').'.csv';

        $collection = Mage::getResourceModel('eav/entity_attribute_option_collection');
        $collection->getSelect()
        ->join(
            array('second_table' => 'eav_attribute'),
            'main_table.attribute_id = second_table.attribute_id',
            array('entity_type_id','frontend_label','attribute_code')
        );
        $collection->addFieldToFilter('main_table.attribute_id', array('in' => $attributes));
        $this->_prepareDownloadResponse($fileName, $content);
        $grid= $this->getLayout()->createBlock('eavmgmt/adminhtml_attribute_exportoption');
        $grid->setCollection($collection);
        
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
        $this->_redirect('*/*/index');
    }

public function importoptionsAction()
{
    $imported = false; // Flag variable

    if ($_FILES['import_options']['error'] == UPLOAD_ERR_OK) {
        $csvFile = $_FILES['import_options']['tmp_name'];
        $csvData = array();

        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $row = array();
                foreach ($data as $value) {
                    $row[] = $value;
                }
                $csvData[] = $row;
            }
            fclose($handle);
        }

        $header = [];
        foreach ($csvData as $rowIndex => $value) {
            if ($rowIndex === 0) {
                $header = $value;
            } else {
                $data = array_combine($header, $value);

                $collection = Mage::getResourceModel('eav/entity_attribute_collection');
                $collection->setCodeFilter($data['Attribute Code']);
                $attribute = $collection->getFirstItem(); // Retrieve the first matching attribute

                $optionValue = $data['Option Name'];
                $optionSortOrder = $data['Option Order'];

                $optionValueTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value');

                $select = Mage::getSingleton('core/resource')->getConnection('core_read')->select();
                $select->from(array('main_table' => $optionValueTable))
                    ->join(
                        array('second_table' => $collection->getTable('eav/attribute_option')),
                        'main_table.option_id = second_table.option_id',
                        array()
                    )
                    ->where('second_table.attribute_id = ?', $attribute->getId())
                    ->where('main_table.value = ?', $optionValue);

                $existingOption = Mage::getSingleton('core/resource')->getConnection('core_read')->fetchOne($select);

                if ($existingOption) {
                    // Option already exists, update the sort order
                    $optionId = $existingOption;
                    $optionModel = Mage::getModel('eav/entity_attribute_option')->load($optionId);
                    $optionModel->setSortOrder($optionSortOrder)->save();

                    $imported = true; // Set flag to true
                } else {
                    // Option doesn't exist, create a new option
                    $optionModel = Mage::getModel('eav/entity_attribute_option')
                        ->setAttributeId($attribute->getId())
                        ->setSortOrder($optionSortOrder)
                        ->save();

                    $optionValueModel = Mage::getModel('eav/entity_attribute_option')
                        ->setValue($optionValue)
                        ->setOptionId($optionModel->getId())
                        ->save();

                    $imported = true; // Set flag to true
                }
            }
        }
    }

    if ($imported) {
        Mage::getSingleton('adminhtml/session')->addSuccess('Options imported successfully.');
    }

    $this->_redirect('*/*/index');
}


}


