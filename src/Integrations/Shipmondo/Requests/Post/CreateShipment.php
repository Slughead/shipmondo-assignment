<?php
/**
 * This request matches the "Create a shipment" endpoint as described in the API doc:
 * 
 * @see https://shipmondo.dev/api-reference#/operations/shipments_post 
 */

namespace App\Integrations\Shipmondo\Requests\Post;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Http\Response;

use App\Dto\ShipmentDto;

class CreateShipment extends Request implements HasBody {

    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string 
    {
        return '/shipments';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();
        return new ShipmentDto(
            package_number: $data['pkg_no'],
            shipment_id: $data['id']
        );
    }

    /**
     * Sets the default body of the request
     * In this case, the body is taken from the sandbox request example on the API doc
     */
    protected function defaultBody(): array
    {
        return [
            "own_agreement" => false,
            "label_format" => "a4_pdf",
            "product_code" => "GLSDK_SD",
            "service_codes" => "EMAIL_NT,SMS_NT",
            "reference" => "Order 10001",
            "automatic_select_service_point" => true,
            "sender" => [
                "name" => "Min Virksomhed ApS",
                "attention" => "Lene Hansen",
                "address1" => "Hvilehøjvej 25",
                "address2" => null,
                "zipcode" => "5220",
                "city" => "Odense SØ",
                "country_code" => "DK",
                "email" => "info@minvirksomhed.dk",
                "mobile" => "70400407"
            ],  
            "receiver" => [
                "name" => "Lene Hansen",
                "attention" => null,
                "address1" => "Skibhusvej 52",
                "address2" => null,
                "zipcode" => "5000",
                "city" => "Odense C",
                "country_code" => "DK",
                "email" => "lene@email.dk",
                "mobile" => "12345678"
            ],
            "parcels" => [
                [
                    "weight" => 1000,
                ],
            ]
        ];
    }
}