<?php
class Hk_Eavmgmt_Block_Adminhtml_Attribute_Grid extends Mage_Eav_Block_Adminhtml_Attribute_Grid_Abstract
{

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('eavmgmt/attribute_collection');
        // $collection = Mage::getResourceModel('eav/entity_attribute_collection');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->addColumn('entity_type_code', array(
            'header'=>Mage::helper('eav')->__('Entity Type'),
            'sortable'=>true,
            'index'=>'entity_type_code'
        ));

        $this->addColumnAfter('is_visible', array(
            'header'=>Mage::helper('eavmgmt')->__('Visible'),
            'sortable'=>true,
            'index'=>'is_visible_on_front',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eavmgmt')->__('Yes'),
                '0' => Mage::helper('eavmgmt')->__('No'),
            ),
            'align' => 'center',
        ), 'frontend_label');

        $this->addColumnAfter('is_global', array(
            'header'=>Mage::helper('eavmgmt')->__('Scope'),
            'sortable'=>true,
            'index'=>'is_global',
            'type' => 'options',
            'options' => array(
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE =>Mage::helper('eavmgmt')->__('Store View'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE =>Mage::helper('eavmgmt')->__('Website'),
                Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL =>Mage::helper('eavmgmt')->__('Global'),
            ),
            'align' => 'center',
        ), 'is_visible');

        $this->addColumn('is_searchable', array(
            'header'=>Mage::helper('eavmgmt')->__('Searchable'),
            'sortable'=>true,
            'index'=>'is_searchable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eavmgmt')->__('Yes'),
                '0' => Mage::helper('eavmgmt')->__('No'),
            ),
            'align' => 'center',
        ), 'is_user_defined');

        $this->addColumnAfter('is_filterable', array(
            'header'=>Mage::helper('eavmgmt')->__('Use in Layered Navigation'),
            'sortable'=>true,
            'index'=>'is_filterable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eavmgmt')->__('Filterable (with results)'),
                '2' => Mage::helper('eavmgmt')->__('Filterable (no results)'),
                '0' => Mage::helper('eavmgmt')->__('No'),
            ),
            'align' => 'center',
        ), 'is_searchable');

        $this->addColumnAfter('is_comparable', array(
            'header'=>Mage::helper('eavmgmt')->__('Comparable'),
            'sortable'=>true,
            'index'=>'is_comparable',
            'type' => 'options',
            'options' => array(
                '1' => Mage::helper('eavmgmt')->__('Yes'),
                '0' => Mage::helper('eavmgmt')->__('No'),
            ),
            'align' => 'center',
        ), 'is_filterable');

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        return $this;
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('attribute_id');
        $this->getMassactionBlock()->setFormFieldName('eavmgmt');

        $this->getMassactionBlock()->addItem('export', array(
             'label'    => Mage::helper('eavmgmt')->__('Export'),
             'url'      => $this->getUrl('*/*/massExport'),
        ));
        return $this;
    }

}
