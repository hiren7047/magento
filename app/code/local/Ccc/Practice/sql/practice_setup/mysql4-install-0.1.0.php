<?php

$installer = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();

$attributeOptions = array(
    'option_1' => 'Red',
    'option_2' => 'Blue',
    'option_3' => 'Green',
    'option_4' => 'Yellow',
    'option_5' => 'Black',
    'option_6' => 'White',
    'option_7' => 'Orange',
    'option_8' => 'Purple',
    'option_9' => 'Pink',
    'option_10' => 'Gray',
);

$installer->addAttribute('catalog_product', 'bottom_color', array(
    'type'          => 'int',
    'input'         => 'select',
    'label'         => 'Bottom Color',
    'required'      => 0,
    'group'         => 'General',
    'sort_order'    => '100',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'       => true,
    'user_defined'  => true,
    'option'        => array(
        'values' => $attributeOptions
    )
));

$installer->addAttribute('catalog_product', 'top_color', array(
    'type'          => 'int',
    'input'         => 'select',
    'label'         => 'Top Color',
    'required'      => 0,
    'group'         => 'General',
    'sort_order'    => '100',
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'       => true,
    'user_defined'  => true,
    'option'        => array(
        'values' => $attributeOptions
    )
));
$installer->endSetup();