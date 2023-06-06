<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('banner')};
CREATE TABLE {$this->getTable('banner')} (
  `banner_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `position` int(10) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE {$this->getTable('banner')}
  ADD PRIMARY KEY (`banner_id`);

ALTER TABLE {$this->getTable('banner')}
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

DROP TABLE IF EXISTS {$this->getTable('banner_group')};
CREATE TABLE {$this->getTable('banner_group')} (
  `group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_key` varchar(255) NOT NULL,
  `height` int(10) NOT NULL,
  `width` int(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  UNIQUE KEY (`group_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE {$this->getTable('banner_group')}
  ADD PRIMARY KEY (`group_id`);

ALTER TABLE {$this->getTable('banner_group')}
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

");

$installer->endSetup();
