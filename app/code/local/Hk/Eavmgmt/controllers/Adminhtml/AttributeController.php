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

        if ($_FILES['import_options']['error'] == UPLOAD_ERR_OK) {
            $csvFile = $_FILES['import_options']['tmp_name'];
            $csvData = file_get_contents($csvFile);
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
            foreach ($csvData as $value)
            {
                if(!$header)
                {
                    $header = $value;
                }
                else
                {
                    $data = array_combine($header,$value);

                    $collection = Mage::getResourceModel('eav/entity_attribute_collection');
                    $collection->setCodeFilter($data['Attribute Code']);
                    $attribute = $collection->getData();

                    $collection = Mage::getModel('eav/entity_attribute_option')->getCollection();
                    $collection->getSelect()
                    ->join(
                        array('eav_attribute_option_value' => Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value')),
                        'main_table.option_id = eav_attribute_option_value.option_id',
                        array('value')
                    )
                    ->where('eav_attribute_option_value.value = ?', $data['Option Name']);
                    $existingOption = $collection->getData();

                    $optionModel = Mage::getModel('eav/entity_attribute_option');
                    if (!$existingOption) {
                        $setData = ['attribute_id' => $attribute[0]['attribute_id'],'sort_order'=>$data['Option Order']];                            
                        $optionModel->setData($setData);
                        $optionModel->save();

                        $resource = Mage::getSingleton('core/resource');
                        $connection = $resource->getConnection('core_write');
                        $tableName = $resource->getTableName('eav_attribute_option_value');

                        $data = array(
                            'option_id' => $optionModel->option_id,
                            'store_id' => 0,
                            'value' => $data['Option Name']
                        );

                        try {
                            $connection->insert($tableName, $data);
                            echo "Value inserted successfully.";
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }


                        echo $optionValueModel->value_id;
                    }
                }
            }
        }

        $this->_redirect('*/*/index');
    }
}
