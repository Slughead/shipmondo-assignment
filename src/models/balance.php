<?php

namespace App\Models;

use \PDO;
use Carbon\Carbon;

class Balance
{
    public function __construct(public \PDO $pdo) 
    {}

    public function insert(
        float $amount,
        string $currency_code,
        Carbon $date
    ): bool 
    {
        $sql = "INSERT INTO balance (`amount`, `currency_code`, `date`)
            VALUES (?, ?, ?);";
        $statement = $this->pdo->prepare($sql);
        $result = $statement->execute([
            $amount, 
            $currency_code,
            $date->toDateTimeString() // making sure, MySQL understands the format
        ]);
        return $result;
    }

    public function getLatest(): array 
    {
        $sql = "SELECT * FROM balance ORDER BY `date` DESC LIMIT 0, 1;";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if ($data === false) {
            return [];
        }
        return $data;
    }
}