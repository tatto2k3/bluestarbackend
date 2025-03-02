<?php

namespace App\Http\Controllers;

include '../ZaloClient.php';
include '../Options/ZaloPayOptions.php';
include '../Options/EmailOptions.php';


use ZaloPayOptions;
use EmailOptions;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallBackController extends Controller
{
    private $zaloPayOptions;
    private $logger;
    private $emailOptions;

    public function __construct(ZaloPayOptions $zaloPayOptions, EmailOptions $emailOptions)
    {
        $this->zaloPayOptions = $zaloPayOptions;
        $this->emailOptions = $emailOptions;
        $this->logger = Log::getLogger();
    }

    public function post(Request $request)
    {
        $result = [];
        $data = $request->json()->all();
        $dataProperty = $data['data'];

        try {
            if (isset($dataProperty)) {
                $dataStr = $dataProperty;
                $reqMac = $data['mac'];
                $key2 = $this->zaloPayOptions->getKey2();
                $mac = hash_hmac('sha256', $dataStr, $key2);

                if ($reqMac !== $mac) {
                    $result['return_code'] = -1;
                    $result['return_message'] = 'mac not equal';
                } else {
                    $dataJson = json_decode($dataStr, true);
                    $amount = $dataJson['amount'];
                    $amount2 = $amount;
                    $item = $dataJson['embed_data'];
                    $itemJson = json_decode($item, true);

                    $customerName = $itemJson['CustomerName'];
                    $customerEmail = $itemJson['CustomerEmail'];
                    $customerIdentify = $itemJson['CustomerIdentify'];
                    $seatID = $itemJson['SeatID'];
                    $flightID = $itemJson['FlightID'];
                    $departureDay = $itemJson['DepeartureDay'];
                    $arriveDay = $itemJson['ArriveDay'];
                    $departureTime = $itemJson['DepeartureTime'];
                    $arriveTime = $itemJson['ArriveTime'];
                    $customerPhone = $itemJson['CustomerPhone'];
                    $durationTime = $itemJson['DurationTime'];
                    $tripType = $itemJson['TripType'];

                    $newTicket = new Ticket([
                        'TId' => $this->generateRandomString(4),
                        'Cccd' => $customerIdentify,
                        'Name' => $customerName,
                        'FlyId' => $flightID,
                        'KgId' => 'K10',
                        'SeatId' => $seatID,
                        'TicketPrice' => $amount2,
                        'Mail' => $customerEmail
                    ]);

                    $newTicket->save();

                    $pdfContent = $this->createPdfDocument($amount2, $customerName, $customerIdentify, $seatID, $flightID, $departureDay, $arriveDay, $departureTime, $arriveTime, $customerPhone, $durationTime, $tripType);

                    $this->sendEmail($pdfContent, $customerName, $customerEmail);
                    
                    $result['return_code'] = 1;
                    $result['return_message'] = 'success';
                }
            }
        } catch (\Exception $ex) {
            $result['return_code'] = 0;
            $result['return_message'] = $ex->getMessage();
            $this->logger->error($ex->getMessage());
        }

        return response()->json($result);
    }

    private function generateRandomString($length)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $randomString;   
    }

    private function createPdfDocument($amount2, $customerName, $customerIdentify, $seatID, $flightID, $departureDay, $arriveDay, $departureTime, $arriveTime, $customerPhone, $durationTime, $tripType)
    {
        // Implement the logic to create a PDF document here
        // You can use libraries like TCPDF, FPDI, or any other suitable library for PDF generation
        // Return the PDF content as a string
        return 'PDF Content';
    }

    private function sendEmail($pdfContent, $customerName, $customerEmail)
    {
        // Implement the logic to send an email with the PDF attachment here
        // Use Laravel Mail facade or any other suitable method for sending emails
    }
}
