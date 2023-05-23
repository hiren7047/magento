<?php

$installer = $this;

$installer->startSetup();


$installer->run("
  
    DROP TABLE IF EXISTS {$this->getTable('salesman')}; 
    CREATE TABLE {$this->getTable('salesman')}  (
  `salesman_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` tinyint(3) NOT NULL DEFAULT 1,
  `mobile` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 2,
  `company` varchar(255) NOT NULL,
  `created_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

     ALTER TABLE {$this->getTable('salesman')}
  ADD PRIMARY KEY (`salesman_id`);

  ALTER TABLE {$this->getTable('salesman')}
  MODIFY `salesman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
    ");
$installer->endSetup();




