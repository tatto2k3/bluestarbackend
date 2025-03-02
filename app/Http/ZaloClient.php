<?php

require_once '../Http/Options/ZaloPayOptions.php';
require_once '../Http/ZaloPayResults/CreateOrderResult.php';
require_once '../Http/DTOs/CreateOrderDTOs.php';
require_once '../Http/DTOs/EmbedData.php';


class ZaloClient
{
    private $zaloPayOptions;
    private $logger;

    public function __construct($options, $logger)
    {
        $this->zaloPayOptions = $options; 
        $this->logger = $logger;
    }

    public function createOrderAsync(CreateTicketOrderDTO $createOrder): CreateOrderResult
    {
        $rnd = rand();
        $app_trans_id = $rnd % 1000000; // Generate a random order's ID.

        echo "appid: " . $this->zaloPayOptions['Appid'] . PHP_EOL;

        $orderZaloPay = new CreateOrderDTOs(
            (int)$this->zaloPayOptions['Appid'],
            $createOrder->getCustomerName(),
            Utils::getTimeStamp(),
            (int)$createOrder->getTicketAmount(),
            date('ymd') . "_" . $app_trans_id,
            " ",
            new EmbedData(
                "https://b94f-171-224-240-4.ngrok-free.app/sign-in",
                $createOrder->getCustomerEmail(),
                $createOrder->getCustomerIdentify(),
                $createOrder->getCustomerName(),
                $createOrder->getCustomerPhone(),
                $createOrder->getDepartureDay(),
                $createOrder->getDepartureTime(),
                $createOrder->getArriveDay(),
                $createOrder->getArriveTime(),
                $createOrder->getSeatID(),
                $createOrder->getFlightID(),
                $createOrder->getDurationTime(),
                $createOrder->getTripType()
            ),
            [
                new Item("", "")
            ],
            "Create Ticket Order for " . $createOrder->getCustomerName(),
            $createOrder->getCustomerPhone(),
            "ngotattopq@gmail.com",
            "Thanh toan tien ve may bay",
            $this->zaloPayOptions['CallbackUrl']
        );

        $orderZaloPay->makeSignature($this->zaloPayOptions['Key1']);
        $result = $orderZaloPay->createOrderAsync($this->zaloPayOptions['Endpoint']);

        return $result;
    }
}
