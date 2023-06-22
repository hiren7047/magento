<?php

die;
$installer = $this;
$installer->startSetup();
 
/*
 * Create all entity tables
 */
$installer->createEntityTables(
    $this->getTable('practice/practice_entity')
);
 
/*
 * Add Entity type
 */
$installer->addEntityType('Ccc_Practice',Array(
    'entity_model'          =>'practice/practice',
    'attribute_model'       =>'',
    'table'                 =>'practice/practice_entity',
    'increment_model'       =>'',
    'increment_per_store'   =>'0'
));
 
$installer->installEntities();
 
$installer->endSetup();