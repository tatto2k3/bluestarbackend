<?php

class CreateOrderResult
{
    public int $return_code;
    public string $return_message;
    public int $sub_return_code;
    public string $sub_return_message;
    public string $order_url;
    public string $zp_trans_token;
    public string $order_token;
}

?>
