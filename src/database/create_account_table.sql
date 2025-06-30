CREATE TABLE `account` (
  `id` int NOT NULL,
  `name` varchar(32) COLLATE utf8mb3_danish_ci DEFAULT NULL,
  `balance` decimal(7,2) DEFAULT NULL,
  `currency_code` varchar(4) COLLATE utf8mb3_danish_ci DEFAULT NULL COMMENT 'ISO 4217',
  PRIMARY KEY (`id`),
  KEY `balance` (`balance`),
  KEY `currency_code` (`currency_code`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_danish_ci;
