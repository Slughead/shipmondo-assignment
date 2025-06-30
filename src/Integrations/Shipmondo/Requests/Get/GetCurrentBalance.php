<?php

namespace App\Integrations\Shipmondo\Requests\Get;

use Saloon\Enums\Methods;
use Saloon\Http\Request;

class GetCurrentBalance extends Request {

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string 
    {
        return '/account/balance';
    }
}