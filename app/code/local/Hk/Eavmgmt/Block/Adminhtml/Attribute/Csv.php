<?php
class Hk_Eavmgmt_Block_Adminhtml_Attribute_Csv extends Mage_Adminhtml_Block_Widget_Grid
{
    protected function _prepareColumns()
    {

        $this->addColumn('attribute_id', array(
            'header'=>Mage::helper('eav')->__('Attribute Id'),
            'sortable'=>true,
            'index'=>'attribute_id'
        ));

        $this->addColumn('entity_type_id', array(
            'header'=>Mage::helper('eav')->__('Entity Type'),
            'sortable'=>true,
            'index'=>'entity_type_id',
            'renderer' => 'Hk_Eavmgmt_Block_Adminhtml_Attribute_Csv_EntityType'
        ));

        $this->addColumn('attribute_code', array(
            'header'=>Mage::helper('eav')->__('Attribute Code'),
            'sortable'=>true,
            'index'=>'attribute_code'
        ));

        $this->addColumn('frontend_label', array(
            'header'=>Mage::helper('eav')->__('Attribute Label'),
            'sortable'=>true,
            'index'=>'frontend_label'
        ));

        $this->addColumn('frontend_input', array(
            'header'=>Mage::helper('eav')->__('Input Type'),
            'sortable'=>true,
            'index'=>'frontend_input'
        ));

        $this->addColumn('backend_type', array(
            'header'=>Mage::helper('eav')->__('backend type'),
            'sortable'=>true,
            'index'=>'backend_type'
        ));

        $this->addColumn('source_model', array(
            'header'=>Mage::helper('eav')->__('Source Model'),
            'sortable'=>true,
            'index'=>'source_model'
        ));

        return $this;
    }
}
