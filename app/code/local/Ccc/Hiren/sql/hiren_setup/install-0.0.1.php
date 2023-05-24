<?php 

$this->startSetup();

$this->addEntityType(Ccc_Hiren_Model_Resource_Hiren::ENTITY,[
	'entity_model'=>'hiren/hiren',
	'attribute_model'=>'hiren/attribute',
	'table'=>'hiren/hiren',
	'increment_per_store'=> '0',
	'additional_attribute_table' => 'hiren/eav_attribute',
	'entity_attribute_collection' => 'hiren/hiren_attribute_collection'
]);

$this->createEntityTables('hiren');
$this->installEntities();

$default_attribute_set_id = Mage::getModel('eav/entity_setup', 'core_setup')
    						->getAttributeSetId('hiren', 'Default');

$this->run("UPDATE `eav_entity_type` SET `default_attribute_set_id` = {$default_attribute_set_id} WHERE `entity_type_code` = 'hiren'");

$this->endSetup();