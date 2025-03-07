<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;
use App\Handle\UtilsEmail;
use App\Models\Ticket;
use App\Models\Customer;

class PaymentController extends Controller
{
    public function handleCallback(Request $request)
    {
        // // Gọi hàm tạo PDF từ UtilsEmail
        // UtilsEmail::createPdfDocument(
        //     $request->input('ticket_amount'),
        //     $request->input('customer_name'),
        //     $request->input('customer_identify'),
        //     $request->input('seat_id'),
        //     $request->input('flight_id'),
        //     $request->input('departure_day'),
        //     $request->input('arrive_day'),
        //     $request->input('departure_time'),
        //     $request->input('arrive_time'),
        //     $request->input('customer_phone'),
        //     $request->input('duration_time'),
        //     $request->input('trip_type'),
        // );

        // // Tạo một bản ghi Ticket
        $passengerList = $request->input('passengerList');

        foreach ($passengerList as $passenger) {
            $ticket = new Ticket();
            $ticket->cccd = $passenger['PassportNumber'];
            $ticket->name = $passenger['FirstName'] . ' ' . $passenger['LastName'];
            $ticket->fly_id = $request->input('flight_id');
            $ticket->seat_id = $passenger['SeatId'];
            $ticket->luggage_id = $passenger['LuggageId'] ?? null;
            $ticket->food_id = $passenger['FoodId'] ?? null;
            $ticket->price = '1200000';
            $ticket->mail = $passenger['Email'];
            $ticket->save();
        }
        return $passengerList[0]['PassportNumber'];
    }
}

// Hàm sinh chuỗi ngẫu nhiên
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}
