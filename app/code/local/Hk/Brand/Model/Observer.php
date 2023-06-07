<?php

class Hk_Brand_Model_Observer
{
    public function prepareRewrite($brandModel)
    {
        $brandId = $brandModel->getId();
        $requestPath = strtolower(str_replace(" ", "-", $brandModel->getData('name'))).'.html';
        $targetPath = 'brand/index/view/brand_id/'.$brandId;
        return $requestPath;
    }

    public function generateRewriteUrl($observer)
    {
        $brand = $observer->getBrand();
        $urlKey = $this->prepareRewrite($brand);
        $brand->getId();
        $rewrite = Mage::getModel('core/url_rewrite');
        $rewrite->setStoreId(1)
                ->setIdPath('brand/' . $brand->getId())
                ->setRequestPath($urlKey)
                ->setTargetPath('brand/index/view/brand_id/'. $brand->getId())
                ->setIsSystem(0)
                ->setOptions('')
                ->setDescription('')
                ->save();
    }
}