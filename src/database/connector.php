<?php

namespace App\database;

use PDO;

class Connector {

    private PDO $connection;

    public function connect(
        string $host, 
        string $dbname, 
        string $username, 
        string $password
    ): PDO {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8";
        try {
            $this->connection = new PDO($dsn, $username, $password);
            if ($this->connection) {
                return $connection;
            }
        } catch (PDOException $e) {
            die('Failed to connect to the database');
            // Note: Normally, we'd have better error handling than this :P
        }
    }

    /**
     * This will ensure that the database is being created if it does not already exist
     * 
     * Note that in a production environment, this would not be the way to go...
     */
    public function createDatabase() {
        // This query is also represented in the /database/create_database.sql file
        $query = "CREATE DATABASE IF NOT EXISTS `shipmondo`";
        $this->connection->exec($query);
        $this->createAccountTable();
        $this->createShipmentTable();
    }

    private function createAccountTable() {
        // This query is also represented in the /database/create_account_table.sql file
        $query = "CREATE TABLE `account` (
            `id` int NOT NULL,
            `name` varchar(32) COLLATE utf8mb3_danish_ci DEFAULT NULL,
            `balance` decimal(7,2) DEFAULT NULL,
            `currency_code` varchar(4) COLLATE utf8mb3_danish_ci DEFAULT NULL COMMENT 'ISO 4217',
            PRIMARY KEY (`id`),
            KEY `balance` (`balance`),
            KEY `currency_code` (`currency_code`),
            KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_danish_ci;
        ";
        $this->connection->exec($query);
    }

    private function createShipmentTable() {
        // This query is also represented in the /database/create_shipment_table.sql file
        $query = "CREATE TABLE IF NOT EXISTS `shipment` (
            `id` int unsigned NOT NULL AUTO_INCREMENT,
            `shipment_id` int unsigned NOT NULL,
            `package_number` varchar(64) COLLATE utf8mb3_danish_ci DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `shipment_id` (`shipment_id`),
            KEY `package_number` (`package_number`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_danish_ci;
        ";
        $this->connection->exec($query);
    }
}