CREATE TABLE IF NOT EXISTS `shipment` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `shipment_id` int unsigned NOT NULL,
  `package_number` varchar(64) COLLATE utf8mb3_danish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipment_id` (`shipment_id`),
  KEY `package_number` (`package_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_danish_ci;
