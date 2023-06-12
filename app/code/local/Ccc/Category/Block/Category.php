<?php

class Ccc_Category_Block_Category extends Mage_Core_Block_Template
{
    public function getCategorys()
    {

        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('image')
            ->addAttributeToSelect('name')
            ->addAttributeToFilter('featured_category', 1)
            ->addIsActiveFilter();
            // echo "<pre>";
            // print_r($categories->getItems());
            // die;
        return $categories;
    }

    public function getCategoryUrl($model)
    {
        $categoryId = $model->entity_id; 
        $storeId = Mage::app()->getStore()->getId();
        $categoryUrl = Mage::getModel('core/url_rewrite')
            ->getResource()
            ->getRequestPathByIdPath('category/' . $categoryId, $storeId);

        return $categoryUrl;
    }
}
