<?php

namespace App\Integrations\Shipmondo\Requests\Post;

use Saloon\Enums\Methods;
use Saloon\Http\Request;

class CreateShipment extends Request {

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string 
    {
        return '/account/balance';
    }
}