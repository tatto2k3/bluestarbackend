<?php
namespace App\Http\Controllers;

include '../ZaloClient.php';
include '../Options/ZaloPayOptions.php';

use ZaloClient;
use ZaloPayOptions;
use Illuminate\Http\Request;

class ZaloController extends Controller
{
    private $zaloClient;
    private $zaloPayOptions;

    public function __construct(ZaloClient $zaloClient, ZaloPayOptions $zaloPayOptions)
    {
        $this->zaloClient = $zaloClient;
        $this->zaloPayOptions = $zaloPayOptions;
    }

    public function createOrderAsync(Request $request)
    {
        $orders = json_decode($request->getContent(), true);

        $result = $this->zaloClient->createOrderAsync($orders);

        return response()->json($result);
    }
}
