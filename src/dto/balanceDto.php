<?php

namespace App\Dto;

use Carbon\Carbon;

class BalanceDto {

    public function __construct(
        public readonly float $amount,
        public readonly string $currency_code,
        public readonly Carbon $date
        // add more here as needed
    ) {}

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency_code' => $this->currency_code,
            'date' => $this->date->toDateTimeString(),
        ];
    }
}