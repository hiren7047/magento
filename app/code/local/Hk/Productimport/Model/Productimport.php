<?php

class Hk_Productimport_Model_Productimport extends Mage_Core_Model_Abstract
{
    function __construct()
    {
        $this->_init('productimport/productimport');
    }

    public function updateMainBrand($productimportBrandNames)
    {
        $brandCollection = Mage::getModel('brand/brand')->getCollection();
        $brandNames = $brandCollection->getConnection()
            ->fetchPairs($brandCollection->getSelect()->columns(['brand_id','name']));

        $newBrands = array_diff($productimportBrandNames, $brandNames);
        foreach ($newBrands as $brandName) {
            $brand = Mage::getModel('brand/brand');
            $brand->name = $brandName;
            $brand->save();
        }

        $newBrandNames = $brandCollection->getConnection()
            ->fetchPairs($brandCollection->getSelect()->columns(['brand_id','name']));
        return $newBrandNames;    
    }
    public function updateMainCollection($productImportCollectionNames)
    {
        $collection = Mage::getModel('collection/collection')->getCollection();
        $collectionName = $collection->getConnection()
            ->fetchPairs($collection->getSelect()->columns(['collection_id','name']));

        $newCollectios = array_diff($productImportCollectionNames, $collectionName);
        foreach ($newCollectios as $collectionName) {
            $collectionmodel = Mage::getModel('collection/collection');
            $collectionmodel->name = $collectionName;
            $collectionmodel->save();
        }

        $newCollectionNames = $collection->getConnection()
            ->fetchPairs($collection->getSelect()->columns(['collection_id','name']));
        return $newCollectionNames;    
    }

     public function updateMainProduct($productImportCollectionNames)
    {
        $collection = Mage::getModel('product/product')->getCollection();
        foreach($collection as $product){
            $collectionName[$product->getData('product_id')] = $product->getData('sku');
        }
        $newCollectios = array_diff($productImportCollectionNames, $collectionName);
        foreach ($newCollectios as $collectionName) {
            $collectionmodel = Mage::getModel('product/product');
            $collectionmodel->sku = $collectionName;
            $collectionmodel->save();
        }

         foreach($collection as $product){
            $newCollectionNames1[$product->getData('product_id')] = $product->getData('sku');
        }
        return $newCollectionNames1;    
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
