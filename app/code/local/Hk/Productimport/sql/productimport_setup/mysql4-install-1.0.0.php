<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('productimport')};
CREATE TABLE {$this->getTable('productimport')} (
  `index` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `quaintity` int(11) DEFAULT NULL,
  `brand` varchar(255) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `collection` varchar(255) NOT NULL,
  `collection_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE {$this->getTable('productimport')}
  ADD PRIMARY KEY (`index`);

ALTER TABLE {$this->getTable('productimport')}
  ADD UNIQUE KEY (`sku`);

ALTER TABLE {$this->getTable('productimport')}
  MODIFY `index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `productimport` ADD FOREIGN KEY (`brand_id`) REFERENCES `brand`(`brand_id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `productimport` ADD FOREIGN KEY (`collection_id`) REFERENCES `collection`(`collection_id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `productimport` ADD FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;


");

$installer->endSetup();
