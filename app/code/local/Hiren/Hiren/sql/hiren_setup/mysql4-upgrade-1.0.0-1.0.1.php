<?php
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$installer->addAttribute(9, 'group_price', array(
    'type'                       => 'decimal',
    'label'                      => 'Group Price',
    'input'                      => 'text',
    'backend'                    => 'catalog/product_attribute_backend_groupprice',
    'required'                   => false,
    'sort_order'                 => 6,
    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
    'apply_to'                   => 'simple,configurable,virtual',
    'group'                      => 'Prices',
));

$installer->endSetup();