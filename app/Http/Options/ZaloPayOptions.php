<?php

class ZaloPayOptions
{
    private $endpoint;
    private $key1;
    private $key2;
    private $appid;
    private $callbackUrl;

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function getKey1()
    {
        return $this->key1;
    }

    public function setKey1($key1)
    {
        $this->key1 = $key1;
    }

    public function getKey2()
    {
        return $this->key2;
    }

    public function setKey2($key2)
    {
        $this->key2 = $key2;
    }

    public function getAppid()
    {
        return $this->appid;
    }

    public function setAppid($appid)
    {
        $this->appid = $appid;
    }

    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
    }
}
