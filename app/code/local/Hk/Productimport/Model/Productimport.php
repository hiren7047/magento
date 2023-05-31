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
        $productCollection = Mage::getModel('catalog/product')->getCollection();
        $productSku = array_column($productCollection->getData(), 'sku');
        $newProducts = array_diff($idxSkus, $productSku);
        
        if($newProducts){
            foreach ($newProducts as $sku) {
                $data[] = [
                    'sku'=>$sku,
                    'type_id'=>'simple',
                    'entity_type_id'=>4,
                    'attribute_set_id'=>4,
                    'created_at'=>now(),
                ];
            }
            // $stockItem = Mage::getModel('cataloginventory/stock_item');
            // $stockItem->assignProduct($newProduct);
            // $stockItem->setData('is_in_stock', 1);
            // $stockItem->setData('qty', 1);
            // $product->setStockItem($stockItem);

            if($data){
                $resource = Mage::getSingleton('core/resource');
                $tableName = $resource->getTableName('catalog_product_entity');
                $writeConnection = $resource->getConnection('core_write');
                $writeConnection->insertMultiple($tableName, $data);
                // die;
            }
        }        

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
