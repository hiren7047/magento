<?php
class Hk_Productimport_Adminhtml_ProductimportController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
    	$this->_title($this->__('Productimport'))
             ->_title($this->__('Manage Productimports'));
       	$this->loadLayout();
       	$this->_addContent($this->getLayout()->createBlock('productimport/adminhtml_productimport'));
	   	$this->renderLayout();
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('productimport/productimport')
            ->_addBreadcrumb(Mage::helper('productimport')->__('Productimport Manager'), Mage::helper('productimport')->__('Productimport Manager'))
            ->_addBreadcrumb(Mage::helper('productimport')->__('Manage productimport'), Mage::helper('productimport')->__('Manage productimport'))
        ;
        return $this;
    }
    

    public function editAction()
    {
        $this->_title($this->__('Productimport'))
             ->_title($this->__('Productimports'))
             ->_title($this->__('Edit Productimports'));

        $id = $this->getRequest()->getParam('productimport_id');
        $model = Mage::getModel('productimport/productimport');

        if ($id) {
            $model->load($id);
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Productimport'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('productimport_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('productimport')->__('Edit Productimport')
                    : Mage::helper('productimport')->__('New Productimport'),
                $id ? Mage::helper('productimport')->__('Edit Productimport')
                    : Mage::helper('productimport')->__('New Productimport'));

        $this->_addContent($this->getLayout()->createBlock('productimport/adminhtml_productimport_edit'))
                ->_addLeft($this->getLayout()->createBlock('productimport/adminhtml_productimport_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('productimport_id') > 0 ) {
            try {
                $model = Mage::getModel('productimport/productimport');
                 
                $model->setId($this->getRequest()->getParam('productimport_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Productimport was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('productimport_id')));
            }
        }
        $this->_redirect('*/*/');
    }

public function massDeleteAction()
{
    $productimportIds = $this->getRequest()->getParam('productimport');
    if (!is_array($productimportIds)) {
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Productimport(s).'));
    } else {
        try {
            $resource = Mage::getSingleton('core/resource');
            $connection = $resource->getConnection('core_write');
            $tableName = $resource->getTableName('productimport');

            $placeholders = array_fill(0, count($productimportIds), '?');
            $condition = '`index` IN (' . implode(',', $placeholders) . ')'; // Add backticks around "index"

            $query = "DELETE FROM {$tableName} WHERE {$condition}";

            $connection->query($query, $productimportIds); // Pass the array of IDs as parameters

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($productimportIds))
            );
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }

    $this->_redirect('*/*/index');
}

     public function downloadAction()
    {
        $filePath = Mage::getModuleDir('', 'Hk_Productimport') . DS . 'data' . DS . 'example.xlsx';
        if (file_exists($filePath)) {
            $this->_prepareDownloadResponse('example.xlsx', file_get_contents($filePath));
        } else {
            $this->_forward('noRoute');
        }
    }
  
   public function importAction()
    {
        try {
            if (isset($_FILES['csv']['tmp_name']) && !empty($_FILES['csv']['tmp_name'])) {

                $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
                $tableName = Mage::getSingleton('core/resource')->getTableName('productimport');

                $connection->truncateTable($tableName);

                $csvFile = $_FILES['csv']['tmp_name'];
                $csvData = array_map('str_getcsv', file($csvFile));

                $columns = $csvData[0];
                unset($csvData[0]);
                $count = 0;
                foreach ($csvData as $data) {
                    $row['sku'] = $data[0];
                    $row[$columns[1]] =  $data[1];
                    $row[$columns[2]] =  $data[2];
                    $row[$columns[3]] =  $data[3];
                    $row[$columns[4]] =  $data[4];
                    $row[$columns[5]] =  $data[5];
                    $row[$columns[6]] =  $data[6];
                    $row[$columns[7]] =  $data[7];
                    $row[$columns[8]] =  $data[8];

                    $connection->insertOnDuplicate($tableName,$row,array_keys($row));
                    $count ++;
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were saved.', $count)
                );
            } else {
                Mage::getSingleton('adminhtml/session')->addError('No CSV file uploaded.');
            }
        } 
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
            $this->_redirect('*/*/index');
    }

    public function brandAction()
    {
        try {
            $productimport = Mage::getModel('productimport/productimport');
            $ProductimportCollection = $productimport->getCollection();
            $ProductimportBrandNames = [];
        
            foreach ($ProductimportCollection as $productimport) {
                $ProductimportBrandNames[] = $productimport->getData('brand');
            }

            $productimport->updateMainBrand(array_unique($ProductimportBrandNames));

            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $sourceTable = Mage::getSingleton('core/resource')->getTableName('brand');
            $destinationTable = Mage::getSingleton('core/resource')->getTableName('productimport');

            $query = "UPDATE {$destinationTable} AS dest
                      INNER JOIN {$sourceTable} AS src ON dest.brand = src.name
                      SET dest.brand_id = src.brand_id";
            $write->query($query);

            Mage::getSingleton('adminhtml/session')->addSuccess('Brand is fine now.');
            $this->_redirect('*/*/');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }
    public function collectionAction()
    {
        try {
            $Productimport = Mage::getModel('productimport/productimport');
            $ProductimportCollection = $Productimport->getCollection();
            $ProductimportCollectionNames = [];
        
            foreach ($ProductimportCollection as $Productimport) {
                $ProductimportCollectionNames[] = $Productimport->getData('collection');
            }

            $newCollections = $Productimport->updateMainCollection(array_unique($ProductimportCollectionNames));

            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $sourceTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value');
            $destinationTable = Mage::getSingleton('core/resource')->getTableName('productimport');

            $query = "UPDATE {$destinationTable} AS dest
                      INNER JOIN {$sourceTable} AS src ON dest.collection = src.value
                      SET dest.collection_id = src.option_id";
            $write->query($query);

            Mage::getSingleton('adminhtml/session')->addSuccess('Collection is fine now.');
            $this->_redirect('*/*/');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }


     public function productAction()
    {
        try {
            $Productimport = Mage::getModel('productimport/productimport');
            $ProductimportCollection = $Productimport->getCollection();
            foreach ($ProductimportCollection as $Productimport) {
                if (!$Productimport->checkBrand()) {
                    Mage::getSingleton('adminhtml/session')->addNotice('Brand is not fine');
                    $this->_redirect('*/*/');
                    return;
                }

                if (!$Productimport->checkCollection()) {
                    Mage::getSingleton('adminhtml/session')->addNotice('Collection is not fine');
                    $this->_redirect('*/*/');
                    return;
                }
            }

            $ProductimportSku = [];
            foreach ($ProductimportCollection as $Productimport) {
                $ProductimportSku[] = $Productimport->getData('sku');
            }

            $newProducts = $Productimport->updateMainProduct(array_unique($ProductimportSku));

            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $sourceTable = Mage::getSingleton('core/resource')->getTableName('catalog_product_entity');
            $destinationTable = Mage::getSingleton('core/resource')->getTableName('productimport');

            $query = "UPDATE {$destinationTable} AS dest
                      INNER JOIN {$sourceTable} AS src ON dest.sku = src.sku
                      SET dest.product_id = src.entity_id";
            $write->query($query);
            
            Mage::getSingleton('adminhtml/session')->addSuccess('Product is fine now');
            $this->_redirect('*/*/');
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }
}