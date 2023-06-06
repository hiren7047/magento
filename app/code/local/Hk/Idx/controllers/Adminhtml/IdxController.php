<?php

class Hk_Idx_Adminhtml_IdxController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('idx/idx')
            ->_addBreadcrumb(Mage::helper('idx')->__('idx Manager'), Mage::helper('idx')->__('idx Manager'))
            ->_addBreadcrumb(Mage::helper('idx')->__('Manage idx'), Mage::helper('idx')->__('Manage idx'))
        ;
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('Idx'))->_title($this->__('Manage Idx'));
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('idx/adminhtml_idx', 'idx')
        );
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        try {
            $this->_title($this->__('idx'))
                 ->_title($this->__('Edit idx'));

            $id = $this->getRequest()->getParam('idx_id');
            $model = Mage::getModel('idx/idx');

            if ($id) {
                $model->load($id);
            }
            $this->_title($model->getId() ? $model->getTitle() : $this->__('New idx'));

            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

            if (!empty($data)) 
            {
                $model->setData($data);
            }

            Mage::register('idx_edit',$model);
            $this->_initAction()
                ->_addBreadcrumb(
                    $id ? Mage::helper('idx')->__('Edit idx')
                        : Mage::helper('idx')->__('New idx'),
                    $id ? Mage::helper('idx')->__('Edit idx')
                        : Mage::helper('idx')->__('New idx'));

            $this->_addContent($this->getLayout()->createBlock('idx/adminhtml_idx_edit'))
                    ->_addLeft($this->getLayout()->createBlock('idx/adminhtml_idx_edit_tabs'));

            $this->renderLayout();
        } 
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }

    public function importAction()
    {
        try {
            if (isset($_FILES['csv']['tmp_name']) && !empty($_FILES['csv']['tmp_name'])) {

                $connection = Mage::getSingleton('core/resource')->getConnection('core_write');
                $tableName = Mage::getSingleton('core/resource')->getTableName('import_product_idx');

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
            $idx = Mage::getModel('idx/idx');
            $idxCollection = $idx->getCollection();
            $idxBrandNames = [];
        
            foreach ($idxCollection as $idx) {
                $idxBrandNames[] = $idx->getData('brand');
            }

            $idx->updateMainBrand(array_unique($idxBrandNames));

            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $sourceTable = Mage::getSingleton('core/resource')->getTableName('brand');
            $destinationTable = Mage::getSingleton('core/resource')->getTableName('import_product_idx');

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
            $idx = Mage::getModel('idx/idx');
            $idxCollection = $idx->getCollection();
            $idxCollectionNames = [];
        
            foreach ($idxCollection as $idx) {
                $idxCollectionNames[] = $idx->getData('collection');
            }

            $newCollections = $idx->updateMainCollection(array_unique($idxCollectionNames));

            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $sourceTable = Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value');
            $destinationTable = Mage::getSingleton('core/resource')->getTableName('import_product_idx');

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
            $idx = Mage::getModel('idx/idx');
            $idxCollection = $idx->getCollection();
            foreach ($idxCollection as $idx) {
                if (!$idx->checkBrand()) {
                    Mage::getSingleton('adminhtml/session')->addNotice('Brand is not fine');
                    $this->_redirect('*/*/');
                    return;
                }

                if (!$idx->checkCollection()) {
                    Mage::getSingleton('adminhtml/session')->addNotice('Collection is not fine');
                    $this->_redirect('*/*/');
                    return;
                }
            }

            $idxSku = [];
            $idxCollection->addFieldToSelect(array('sku', 'name', 'price','cost','quantity','description'));
            $idxCollectionArray = $idxCollection->getData();
            $idxSku = array_column($idxCollectionArray, 'sku');

            $idxProductData = $idxCollection->getData();
            $idx->updateProductAttribute($idxProductData);

           $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $sourceTable = Mage::getSingleton('core/resource')->getTableName('catalog_product_entity');
            $destinationTable = Mage::getSingleton('core/resource')->getTableName('import_product_idx');

            $query = "UPDATE {$destinationTable} AS dest
                      INNER JOIN {$sourceTable} AS src ON dest.sku = src.sku
                      SET dest.product_id = src.entity_id";
            $write->query($query);

            Mage::getSingleton('adminhtml/session')->addSuccess("Products is fine now.");
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
    }
}
