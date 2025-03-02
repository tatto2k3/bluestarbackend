<?php


class CreateOrderDTOs
{
    public $AppId;
    public $AppUser;
    public $AppTime;
    public $Amount;
    public $AppTransId;
    public $BankCode;
    public $EmbedData;
    public $Item;
    public $Description;
    public $Mac;
    public $Phone;
    public $Email;
    public $Title;
    public $CallBackURL;

    public function __construct($appId, $appUser, $appTime, $amount, $appTransId, $bankCode, $embedData, $item, $description, $phone, $email, $title, $callback)
    {
        $this->AppId = $appId;
        $this->AppUser = $appUser;
        $this->AppTime = $appTime;
        $this->Amount = $amount;
        $this->AppTransId = $appTransId;
        $this->BankCode = $bankCode;
        $this->EmbedData = $embedData;
        $this->Item = $item;
        $this->Description = $description;
        $this->Phone = $phone;
        $this->Email = $email;
        $this->Title = $title;
        $this->CallBackURL = $callback;
    }

    public function makeSignature($key1)
    {
        $data = $this->AppId . "|" . $this->AppTransId . "|" . $this->AppUser . "|" . $this->Amount . "|"
            . $this->AppTime . "|" . json_encode($this->EmbedData) . "|" . json_encode($this->Item);

        $this->Mac = hash_hmac('sha256', $data, $key1);
    }

    public function getContent()
    {
        $keyValuePairs = [
            "app_id" => $this->AppId,
            "app_user" => $this->AppUser,
            "app_time" => $this->AppTime,
            "amount" => $this->Amount,
            "app_trans_id" => $this->AppTransId,
            "embed_data" => json_encode($this->EmbedData),
            "item" => json_encode($this->Item),
            "description" => $this->Description,
            "bank_code" => "",
            "mac" => $this->Mac,
            "phone" => $this->Phone,
            "email" => $this->Email,
            "title" => $this->Title,
            "callback_url" => $this->CallBackURL,
        ];

        return $keyValuePairs;
    }

    public function createOrderAsync($createOrderUrl)
    {
        $content = http_build_query($this->getContent());
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => $content,
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($createOrderUrl, false, $context);

        // Assuming CreateOrderResult is a class you've defined to handle the response
        return json_decode($result, true);
    }
}
