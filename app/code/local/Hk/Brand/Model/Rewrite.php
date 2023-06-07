<?php

class Hk_Brand_Model_Rewrite extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('brand/brand_rewrite');
    }

    public function generateRewrite($brandId, $requestPath, $targetPath, $storeId = 0, $isSystem = 0)
    {
        $rewrite = Mage::getModel('brand/rewrite');
        $rewrite->setBrandId($brandId);
        $rewrite->setRequestPath($requestPath);
        $rewrite->setTargetPath($targetPath);
        $rewrite->setStoreId($storeId);
        $rewrite->setIsSystem($isSystem);
        $rewrite->save();
    }

    public function deleteRewrites($brandId)
    {
        $collection = $this->getCollection()->addFieldToFilter('brand_id', $brandId);
        foreach ($collection as $rewrite) {
            $rewrite->delete();
        }
    }

    public function prepareRewrite($brandModel)
    {
        $brandId = $brandModel->getId();
        $requestPath = strtolower(str_replace(" ", "-", $brandModel->getData('name'))).'.html';
        $targetPath = 'brand/index/view/brand_id/'.$brandId;
        $this->generateRewrite($brandId,$requestPath,$targetPath);
        return true;
    }
}