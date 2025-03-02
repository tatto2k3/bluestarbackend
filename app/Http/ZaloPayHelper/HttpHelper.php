<?php

class HttpHelper
{
    public static function post($uri, $content)
    {
        $httpClient = new \GuzzleHttp\Client();
        $response = $httpClient->post($uri, [
            'body' => $content,
        ]);

        $responseString = $response->getBody()->getContents();
        $result = json_decode($responseString, true);

        return $result;
    }
}
