<?php

namespace App\Integrations\Shipmondo;

use Saloon\Http\Connector;

class ShipmondoConnector extends Connector
{

    public function __construct(
        public readonly string $username,   // API username
        public readonly string $password    // API key
    ) {}

    public function resolveBaseUrl(): string
    {
        /**
         * Normally you'd put the actual URL in the config, so the URL can change
         * based on the current environment and maybe even version.
         * In this case however, we will just hardcode the sandbox environment in version 3
         */
        return 'https://sandbox.shipmondo.com/api/public/v3';
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new BasicAuthenticator($this->username, $this->password);
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
};