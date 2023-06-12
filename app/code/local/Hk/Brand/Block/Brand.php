<?php
class Hk_Brand_Block_Brand extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBrand()
    {
        $brandId = $this->getRequest()->getParam('brand_id');
        $brand = Mage::getModel('brand/brand')->load($brandId);
        return $brand;
    }

    public function getBrands()
    {
        $brands = Mage::getModel('brand/brand')->getCollection();
        $brands->addFieldToFilter('status',1);
        $brands->setOrder('sort_order', 'ASC');
        return $brands;
    }

    public function getRewriteUrl($brand)
    {
        $requestPath = strtolower(str_replace(" ", "-", $brand->getData('name'))).'.html';
        return $requestPath;
    }

     public function getProductsByBrand()
    {
        $brandAttributeCode = 'brand';
        $brandAttribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $brandAttributeCode);

        $brandValue = $this->getRequest()->getParam('brand_id');
        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter($brandAttributeCode, $brandValue)
            ->getAllIds();

        $categoryId = $this->getRequest()->getParam('category');
        $products = Mage::getModel('catalog/product')->getCollection()
            ->addIdFilter($productCollection)
            ->addCategoryFilter(Mage::getModel('catalog/category')->load($categoryId))
            ->addAttributeToSelect('*');
        return $products;
    }

       public function getProductUrl($product)
    {
        $productId = $product->getId(); 
        $rewrite = Mage::getModel('core/url_rewrite')->load($productId,'product_id');
        $requestPath = $rewrite->getRequestPath();
        return $requestPath;
    }

    public function getCategory()
    {
        $categories = Mage::getModel('catalog/category')
        ->getCollection()
        ->addAttributeToSelect('*')
        ->addIsActiveFilter();

        return $categories;
    }
}