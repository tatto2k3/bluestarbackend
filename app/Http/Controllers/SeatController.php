<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class SeatController extends Controller
{
    public function getAllSeats()
    {
        try {
            $seats = Seat::all();
            return response()->json($seats);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal Server Error: ' . $ex->getMessage()], 500);
        }
    }
}
