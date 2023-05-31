<?php

class Hk_Productimport_Model_Productimport extends Mage_Core_Model_Abstract
{
    function __construct()
    {
        $this->_init('productimport/productimport');
    }

   public function updateMainBrand($idxBrandNames)
    {
        $brandCollection = Mage::getModel('brand/brand')->getCollection();
        $brandNames = $brandCollection->getConnection()
            ->fetchPairs($brandCollection->getSelect()->columns(['brand_id','name']));

        $newBrands = array_diff($idxBrandNames, $brandNames);

        $data = null;
        foreach ($newBrands as $name) {
            $data[] = ['name'=>$name,'created_at'=>now()];
        }

        if($data){
            $resource = Mage::getSingleton('core/resource');
            $tableName = $resource->getTableName('brand');
            $writeConnection = $resource->getConnection('core_write');
            $writeConnection->insertMultiple($tableName, $data);
        }

        return true;
    }

   public function updateMainCollection($idxCollectionNames)
    {
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product','collection');

        $options = $attribute->getSource()->getAllOptions();
        $existOption = array_filter(array_column($options,'label'));

        $newOptions = array_diff($idxCollectionNames, $existOption);
        if($newOptions){
            $count = 1;
            foreach ($newOptions as $key => $value) 
            {
                $option['attribute_id'] = $attribute->getId();
                $option['value'] = array(0 => array($value));
                $option['sort_order'] = $count;

                $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
                $setup->addAttributeOption($option);
                $count++;
            }
        }

        return true;    
    }

    public function updateMainProduct($idxSkus)
    {
       $resource = Mage::getSingleton('core/resource');
        $connection = $resource->getConnection('core_write');
        $sourceTableName = $resource->getTableName('productimport');
        $destinationTableName = $resource->getTableName('cataloginventory_stock_item');

        $query = "INSERT INTO {$destinationTableName} (product_id, qty, stock_id)
                        SELECT product_id, quantity , 1
                        FROM {$sourceTableName}";
        $connection->query($query);

        $destinationTableName = $resource->getTableName('catalog_product_entity_int');
        $query = "INSERT INTO {$destinationTableName} (entity_type_id, attribute_id, store_id,entity_id,value)
                        SELECT 4 , 98 , 0 , product_id , status
                        FROM {$sourceTableName}";
        $connection->query($query);
        
        $query = "INSERT INTO {$destinationTableName} (entity_type_id, attribute_id, store_id,entity_id,value)
                        SELECT 4 , 104 , 0 , product_id , 4
                        FROM {$sourceTableName}";
        $connection->query($query);
        return true;
    }

    public function checkBrand()
    {
        $idxBrandId = $this->getData('brand_id');
        if (!$idxBrandId) {
            return false;
        }
        return true;
    }

    public function checkCollection()
    {
        $idxCollectionId = $this->getData('collection_id');
        if (!$idxCollectionId) {
            return false;
        }
        return true;
    }
}
