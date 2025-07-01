<?php

namespace App;

use App\Integrations\Shipmondo\ShipmondoConnector;
use App\Integrations\Shipmondo\Requests\Post\CreateShipment;
use App\Integrations\Shipmondo\Requests\Get\GetCurrentBalance;
use App\Dto\ShipmentDto;
use App\Dto\BalanceDto;
use App\Database\Connector AS DatabaseConnector;
use \PDO;
use Carbon\Carbon;
use App\Models\Balance AS BalanceModel;
use App\Models\Shipment AS ShipmentModel;

class Application 
{
    private $config = [];
    private ?\PDO $pdo = null;

    public function run(): void 
    {
        $this->init();
        $this->simulateAssignment();
    }

    private function init(): void 
    {
        $this->config['databases'] = require_once "config/db.php";
        $connector = new DatabaseConnector();
        $databaseConfig = $this->config['databases']['shipmondo'];
        $this->pdo = $connector->connect(
            $databaseConfig['host'], 
            $databaseConfig['dbname'], 
            $databaseConfig['charset'],
            $databaseConfig['port'],
            $databaseConfig['username'], 
            $databaseConfig['password']
        );
        $connector->createDatabase();
        $this->config['integrations'] = require_once "config/integrations.php";
    }

    /**
     * This function simulates how to use the very basics of the Shipmondo API, 
     * as instructed in the assignment itself:
     * 
     * "Your application must cover the following aspects:
     *
     * It must securely authenticate with the keys provided by your contact at Shipmondo.
     * 
     * It must be able to create a simple shipment. It is fine that the body of the shipment request is hardcoded.
     * 
     * It must have a local database that keeps track of:
     *  Your account balance.
     *  Package number and ID of the shipment.
     * 
     * It must retrieve the balance from the API, and keep track of the balance of the account as it is updated when creating shipments."
     */
    private function simulateAssignment(): void
    {
        // initiate the API connector
        $shipmondoAPIConfig = $this->config['integrations']['shipmondo'];
        $shipmondoConnector = new ShipmondoConnector(
            $shipmondoAPIConfig['username'], 
            $shipmondoAPIConfig['password']
        );

        // creates the required models that will be used for persistence
        $balanceModel = new BalanceModel($this->pdo);
        $shipmentModel = new ShipmentModel($this->pdo);

        // fetch, save and show the current account balance
        $balanceDto = $this->getRemoteBalance($shipmondoConnector);
        $this->persistBalance($balanceModel, $balanceDto);
        $this->showCurrentBalance($balanceModel);
        
        // create a dummy shipment using hardcoded data and save it based on the API response
        $shipmentDto = $this->createShipment($shipmondoConnector);
        $this->persistShipment($shipmentModel, $shipmentDto);

        // fetch, save and show the current account balance, yet again. 
        // This seems clonky, but it's done to show the balance change after creating a shipment.
        $balanceDto = $this->getRemoteBalance($shipmondoConnector);
        $this->persistBalance($balanceModel, $balanceDto);
        $this->showCurrentBalance($balanceModel);
    }

    private function getRemoteBalance(ShipmondoConnector $connector): BalanceDto
    {
        echo "\n - [action] Fetching the account balance remotely via the API:\n";
        $getCurrentBalanceRequest = new GetCurrentBalance();
        $response = $connector->send($getCurrentBalanceRequest);
        $balanceDto = $response->dtoOrFail();
        print_r($balanceDto->toArray());
        return $balanceDto;
    }

    private function persistBalance(BalanceModel $model, BalanceDto $dto): void
    {
        echo "\n - [action] Saving the fetched balance in the database.\n";
        if ($model->insert($dto->amount, $dto->currency_code, $dto->date) === false) {
            throw new LogicException('Failed to save the current balance');
        }
    }

    private function showCurrentBalance(BalanceModel $model): void
    {
        $latestRow = $model->getLatest();
        echo "\n - [action] Getting the current balance (newest row in the database):\n";
        print_r($latestRow);
        echo "\n";
    }

    private function createShipment(ShipmondoConnector $connector): ShipmentDto 
    {
        echo "\n - [action] Creating a shipment remotely via the API.\n";
        $createShipmentRequest = new CreateShipment();
        $response = $connector->send($createShipmentRequest);
        $shipmentDto = $response->dtoOrFail();
        print_r($shipmentDto->toArray());
        return $shipmentDto;
    }
        
    private function persistShipment(ShipmentModel $model, ShipmentDto $dto): void 
    {
        echo "\n - [action] Saving the created shipment in the database.\n";
        if ($model->insert($dto->package_number, $dto->shipment_id) === false) {
            throw new LogicException('Failed to save the new shipment');
        }
    }
}