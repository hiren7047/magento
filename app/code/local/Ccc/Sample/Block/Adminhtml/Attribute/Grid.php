<?php
class Ccc_Sample_Block_Adminhtml_Attribute_Grid extends Mage_Eav_Block_Adminhtml_Attribute_Grid_Abstract
{

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('sample/attribute_collection')
            ->addVisibleFilter();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->addColumnAfter('is_visible', array(
            'header'=>Mage::helper('sample')->__('Visible'),
            'sortable'=>true,
            'index'=>'is_visible_on_front',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('sample')->__('Yes'),
                '0' => Mage::helper('sample')->__('No'),
            ),
            'align' => 'center',
        ), 'frontend_label');

        $this->addColumnAfter('is_global', array(
            'header'=>Mage::helper('sample')->__('Scope'),
            'sortable'=>true,
            'index'=>'is_global',
            'type' => 'options',
            'options' => array(
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE =>Mage::helper('sample')->__('Store View'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE =>Mage::helper('sample')->__('Website'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL =>Mage::helper('sample')->__('Global'),
            ),
            'align' => 'center',
        ), 'is_visible');

        $this->addColumn('is_searchable', array(
            'header'=>Mage::helper('sample')->__('Searchable'),
            'sortable'=>true,
            'index'=>'is_searchable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('sample')->__('Yes'),
                '0' => Mage::helper('sample')->__('No'),
            ),
            'align' => 'center',
        ), 'is_user_defined');

        $this->addColumnAfter('is_filterable', array(
            'header'=>Mage::helper('sample')->__('Use in Layered Navigation'),
            'sortable'=>true,
            'index'=>'is_filterable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('sample')->__('Filterable (with results)'),
                '2' => Mage::helper('sample')->__('Filterable (no results)'),
                '0' => Mage::helper('sample')->__('No'),
            ),
            'align' => 'center',
        ), 'is_searchable');

        $this->addColumnAfter('is_comparable', array(
            'header'=>Mage::helper('sample')->__('Comparable'),
            'sortable'=>true,
            'index'=>'is_comparable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('sample')->__('Yes'),
                '0' => Mage::helper('sample')->__('No'),
            ),
            'align' => 'center',
        ), 'is_filterable');

        return $this;
    }
}
