<?php

class Hk_Eavmgmt_Model_Resource_Attribute_Collection
    extends Mage_Eav_Model_Resource_Entity_Attribute_Collection
{
   
    protected function _construct()
    {
        $this->_init('eav/entity_attribute');
    }

    protected function _initSelect()
    {
        $this->getSelect()
            ->from(array('main_table' => $this->getResource()->getMainTable()))
            ->joinLeft(
                array('additional_table' => $this->getTable('catalog/eav_attribute')),
                'additional_table.attribute_id = main_table.attribute_id'
                )
            ->joinLeft(
                array('entity_table' => $this->getTable('eav/entity_type')),
                'entity_table.entity_type_id = main_table.entity_type_id'
                );
        return $this;
    }
}
