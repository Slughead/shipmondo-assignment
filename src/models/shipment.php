<?php

namespace App\Models;

use \PDO;

class Shipment
{
    public function __construct(public readonly \PDO $pdo) 
    {}

    public function insert(
        string $package_number,
        int $shipment_id
    ): bool 
    {
        $sql = "INSERT INTO shipment (`shipment_id`, `package_number`)
            VALUES (:shipment_id, :package_number);";
        $statement = $this->pdo->prepare($sql);
        return $statement->execute([
            ':shipment_id' => $shipment_id, 
            ':package_number' => $package_number
        ]);
    }

    public function getLatest(): array 
    {
        $sql = "SELECT * FROM shipment ORDER BY `id` DESC LIMIT 0, 1;";
        return $this->pdo->prepare($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll($pagesize = 25): array 
    {
        $sql = "SELECT * FROM shipment ORDER BY `id` DESC LIMIT 0, :pagesize;";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([':pagesize' => $pagesize]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCount(): int
    {
        $sql = "SELECT COUNT(*) AS 'count' FROM shipment;";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data === false ? 0 : $data['count'];
    }
}