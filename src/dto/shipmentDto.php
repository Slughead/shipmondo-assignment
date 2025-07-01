<?php

namespace App\Dto;

class ShipmentDto {

    public function __construct(
        public readonly string $package_number,
        public readonly int $shipment_id
    ) {}

    public function toArray(): array
    {
        return [
            'package_number' => $this->package_number,
            'shipment_id' => $this->shipment_id,
        ];
    }
}