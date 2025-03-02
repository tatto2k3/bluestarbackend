<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class SeatController extends Controller
{
    public function getSeatByFlight(Request $request)
    {
        try {
            $flightId = $request->input('FlightId');

            $seats = Seat::where('FLIGHT_ID', $flightId)
                ->select('SEAT_ID', 'SEAT_TYPE', 'FLIGHT_ID', 'ISBOOKED')
                ->get();

            return response()->json($seats);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal Server Error: ' . $ex->getMessage()], 500);
        }
    }
}
