<?php 

$this->startSetup();

$this->addEntityType(Ccc_HirenAttr_Model_Resource_HirenAttr::ENTITY,[
	'entity_model'=>'hirenAttr/hirenAttr',
	'attribute_model'=>'hirenAttr/attribute',
	'table'=>'hirenAttr/hirenAttr',
	'increment_per_store'=> '0',
	'additional_attribute_table' => 'hirenAttr/eav_attribute',
	'entity_attribute_collection' => 'hirenAttr/hirenAttr_attribute_collection'
]);

$this->createEntityTables('hirenAttr');
$this->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
    						->getAttributeSetId('hirenAttr', 'Default');

$this->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'hirenAttr'");

$this->endSetup();