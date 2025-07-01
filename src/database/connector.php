<?php

namespace App\Database;

use PDO;

class Connector {

    private PDO $connection;

    public function connect(
        string $host, 
        string $dbname, 
        string $charset, // UTF8
        int $port,
        string $username, 
        string $password
    ): PDO 
    {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
        try {
            $this->connection = new PDO($dsn, $username, $password);
            if ($this->connection) {
                return $this->connection;
            }
        } catch (PDOException $e) {
            throw new Exception('Failed to connect to the database');
        }
    }

    /**
     * This will ensure that the database tables are being created if they don't already exist
     * 
     * This works for now, but it's not how to do it in a production environment
     */
    public function createDatabase(): void 
    {
        $this->createBalanceTable();
        $this->createShipmentTable();
    }

    private function createBalanceTable(): void 
    {
        $query = "CREATE TABLE IF NOT EXISTS `balance` (
            `id` int NOT NULL AUTO_INCREMENT,
            `amount` float NOT NULL,
            `currency_code` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_danish_ci NOT NULL COMMENT 'ISO 4217',
            `date` datetime NOT NULL,
            PRIMARY KEY (`id`),
            KEY `currency_code` (`currency_code`),
            KEY `date` (`date`),
            KEY `balance` (`amount`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_danish_ci COMMENT='Shows the account balance, over time';
        ";
        $this->connection->exec($query);
    }

    private function createShipmentTable(): void
    {
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