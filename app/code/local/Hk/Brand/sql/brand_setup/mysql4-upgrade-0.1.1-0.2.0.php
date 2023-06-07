<?php
$installer = $this;

$installer->startSetup();
$installer->run("

ALTER TABLE `brand` ADD `banner_image` VARCHAR(255) NOT NULL AFTER `update_time`, ADD `status` TINYINT(2) NOT NULL AFTER `banner_image`, ADD `sort_order` INT NOT NULL DEFAULT '0' AFTER `status`;
    
");

$table = $installer->getConnection()
    ->newTable($installer->getTable('brand_rewrite'))
    ->addColumn('rewrite_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Rewrite ID')
    ->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Brand ID')
    ->addColumn('request_path', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Request Path')
    ->addColumn('target_path', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Target Path')
    ->addColumn('is_system', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable' => false,
        'default'  => '0',
    ), 'Defines if the rewrite is a system rewrite')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '0',
    ), 'Store ID')
    ->addIndex($installer->getIdxName('brand_rewrite', array('request_path', 'store_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('request_path', 'store_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addForeignKey($installer->getFkName('brand_rewrite', 'brand_id', 'brand/brand', 'brand_id'),
        'brand_id', $installer->getTable('brand/brand'), 'brand_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('brand_rewrite', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Brand URL Rewrites');

$installer->getConnection()->createTable($table);

$installer->endSetup();