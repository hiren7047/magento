<?php
class Hk_Brand_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function viewAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function catAction()
    {
        print_r($this->getCategoryProduct());
    }

    public function getCategoryProduct()
    {
        $categoryId = $this->getRequest()->getParam('c');   
        $category = Mage::getModel('catalog/category')->load($categoryId);

        $productCollection = Mage::getModel('catalog/product')->getCollection()
            ->addCategoryFilter($category)
            ->addAttributeToSelect('*');
        return $productCollection->toArray();
    }
}