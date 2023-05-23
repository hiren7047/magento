<?php

$installer = $this;

$installer->startSetup();

$installer->run("
  CREATE TABLE `sample_address` (
  `address_id` int(11) NOT NULL,
  `sample_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `country` text NOT NULL,
  `zip_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `sample_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `customer_id` (`sample_id`);

  ALTER TABLE `sample_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

  ALTER TABLE `sample_address`
  ADD CONSTRAINT `sample_address_ibfk_1` FOREIGN KEY (`sample_id`) REFERENCES `sample` (`entity_id`) ON DELETE CASCADE;

  DROP TABLE IF EXISTS {$this->getTable('sample_price')}; 
    CREATE TABLE {$this->getTable('sample_price')}  (
  `entity_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `gender` tinyint(3) NOT NULL DEFAULT 1,
  `price` int(11) NOT NULL,
  `sample_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 2,
  `company` varchar(255) NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

     ALTER TABLE {$this->getTable('sample_price')}
  ADD PRIMARY KEY (`entity_id`);

  ALTER TABLE {$this->getTable('sample_price')}
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

 
");


$installer->endSetup();