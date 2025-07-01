<?php
/**
 * This request matches the "Retrieve balance" endpoint as described in the API doc:
 * 
 * @see https://shipmondo.dev/api-reference#/operations/account_balance_get
 */

namespace App\Integrations\Shipmondo\Requests\Get;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\Carbon;
use App\Dto\BalanceDto;

class GetCurrentBalance extends Request {

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string 
    {
        return '/account/balance';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();
        return new BalanceDto(
            amount: $data['amount'],
            currency_code: $data['currency_code'],
            date: Carbon::parse($data['updated_at'])
        );
    }
}