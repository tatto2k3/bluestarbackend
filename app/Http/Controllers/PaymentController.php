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
        // Gọi hàm tạo PDF từ UtilsEmail
        UtilsEmail::createPdfDocument(
            $request->input('ticket_amount'),
            $request->input('customer_name'),
            $request->input('customer_identify'),
            $request->input('seat_id'),
            $request->input('flight_id'),
            $request->input('departure_day'),
            $request->input('arrive_day'),
            $request->input('departure_time'),
            $request->input('arrive_time'),
            $request->input('customer_phone'),
            $request->input('duration_time'),
            $request->input('trip_type'),
        );

        // Tạo một bản ghi Ticket
        $ticket = new Ticket();
        $ticket->t_id = generateRandomString(4);
        $ticket->cccd = $request->input('customer_identify');
        $ticket->name = $request->input('customer_name');
        $ticket->fly_id = $request->input('flight_id');
        $ticket->kg_id = "K10";
        $ticket->seat_id = $request->input('seat_id');
        $ticket->food_id = "FD07";
        $ticket->ticket_price = $request->input('ticket_amount');
        $ticket->dis_id = "D01";
        $ticket->mail = $request->input('customer_email');
        $ticket->save();

  

        return 1;
    }
}

// Hàm sinh chuỗi ngẫu nhiên
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}
