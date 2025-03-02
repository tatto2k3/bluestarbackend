<?php

class HmacHelper
{
    public static function compute($algorithm = 'sha256', $key = '', $message = '')
    {
        $hashMessage = hash_hmac($algorithm, $message, $key, false);
        return $hashMessage;
    }
}
