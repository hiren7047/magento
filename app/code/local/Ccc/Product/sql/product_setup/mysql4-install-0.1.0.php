<?php

$installer = $this;

$installer->startSetup();

$installer->run("

    CREATE TABLE IF NOT EXISTS {$this->getTable('product')} (
      `product_id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `sku` varchar(255) NOT NULL,
      `price` decimal(10,2) NOT NULL,
      `cost` decimal(10,2) NOT NULL,
      `quantity` int(11) NOT NULL,
      `description` varchar(255) NOT NULL,
      `status` tinyint(2) NOT NULL DEFAULT 2,
      `created_time` datetime NOT NULL,
      `update_time` datetime DEFAULT NULL,
      PRIMARY KEY (`product_id`),
      UNIQUE KEY `sku` (`sku`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    ");

$installer->endSetup();




