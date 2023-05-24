<?php 

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addKey($installer->getTable('hirenAttr/hirenAttr_decimal'),
    'UNQ_HIRENATTR_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('hirenAttr/hirenAttr_datetime'),
    'UNQ_HIRENATTR_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('hirenAttr/hirenAttr_int'),
    'UNQ_HIRENATTR_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->getConnection()->addKey($installer->getTable('hirenAttr/hirenAttr_text'),
    'UNQ_HIRENATTR_DECIMAL', array('entity_id','attribute_id', 'store_id'), 'unique');

$installer->endSetup();

?>