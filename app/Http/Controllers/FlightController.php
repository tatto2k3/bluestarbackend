<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use DateTime;

class FlightController extends Controller
{
    function addFlight(Request $request){
        $Flight = new Flight;
        $Flight->flyID = $request->input('flyID');
        $Flight->pl_id = $request->input('Pl_ID');
        $Flight->fromLocation = $request->input('fromLocation');
        $Flight->toLocation = $request->input('toLocation');
        $Flight->departureTime = $request->input('departureTime');
        $Flight->arrivalTime = $request->input('arrivalTime');
        $Flight->departureDay = $request->input('departureDay');
        $Flight->originalPrice = $request->input('originalPrice');
        $Flight->save();

        return $Flight;
    }

    function getFlights()
    {
        $Flights = Flight::all();
         return response()->json($Flights);
    }
    function updateFlight(Request $request){
        
        try {
        // Validate the request data as needed
            $request->validate([
                'flyID' => 'required',
                'Pl_ID' => 'required',
                'fromLocation' => 'required',
                'toLocation' => 'required',
                'departureTime' => 'required',
                'arrivalTime' => 'required',
                'departureDay' => 'required',
                'originalPrice' => 'required',
            ]);

            // Find the Flight by cId
            $Flight = Flight::where('flyID', $request->input('flyID'))->first();

            if (!$Flight) {
                return response()->json(['error' => 'Flight not found'], 404);
            }

            // Update Flight data
            $Flight->Pl_ID = $request->input('Pl_ID');
            $Flight->fromLocation = $request->input('fromLocation');
            $Flight->toLocation = $request->input('toLocation');
            $Flight->departureTime = $request->input('departureTime');
            $Flight->arrivalTime = $request->input('arrivalTime');
            $Flight->departureDay = $request->input('departureDay');
            $Flight->originalPrice = $request->input('originalPrice');
            $Flight->save();

            return response()->json(['message' => 'Flight updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(($e->getMessage()), 500);
        }
    }


    function getFlightDetails(Request $request)
    {
        $selectedFlights = $request->input('flyIds');

        // Chuyển chuỗi cIds thành mảng
        $selectedFlightIds = explode(',', $selectedFlights);

        // Lấy chi tiết của các khách hàng được chọn
        $FlightDetails = Flight::whereIn('flyID', $selectedFlightIds)->get();

        return response()->json($FlightDetails);
    }

    function deleteFlight($flyId)
    {
        try {
            // Tìm khách hàng dựa trên C_ID
            $Flight = Flight::where('flyID', $flyId)->first();

            if (!$Flight) {
                return response()->json(['error' => 'Flight not found'], 404);
            }

            // Xóa khách hàng
            $Flight->delete();

            return response()->json(['message' => 'Flight deleted successfully'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function searchFlights(Request $request)
    {
        try {
            $searchKeyword = $request->input('searchKeyword');

            if (empty($searchKeyword)) {
                return response()->json(['error' => 'Invalid search keyword'], 400);
            }

            // Search Flights by name containing the provided keyword
            $searchResults = Flight::where('FULLNAME', 'like', '%' . $searchKeyword . '%')
                ->orWhere('NUM_ID', 'like', '%' . $searchKeyword . '%')
                ->orWhere('C_ID', 'like', '%' . $searchKeyword . '%')
                ->get();

            return response()->json($searchResults);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
        }
    }

    public function searchFlight(Request $request)
{
    try {
        $departureDay = null;

        // Extract the day value and convert it to a string
        $day = substr($request->input('departureDay'), 8, 2);
        $month = substr($request->input('departureDay'), 5, 2);
        $year = substr($request->input('departureDay'), 0, 4);

        $departureDay = "{$year}-{$month}-{$day}";

        $flightsQuery = Flight::where('fromLocation', $request->input('fromLocation'))
            ->where('toLocation', $request->input('toLocation'))
            ->where('departureDay', $departureDay);

        if ($request->input('departureTime') !== null && $request->input('arrivalTime') !== null) {
            $hourArrival = substr($request->input('arrivalTime'), 0, 2);
            $hourDepart = substr($request->input('departureTime'), 0, 2);

            $flightsQuery->where(function ($query) use ($hourDepart, $hourArrival) {
                $query->whereRaw("CAST(SUBSTRING(departureTime, 1, 2) AS SIGNED) >= {$hourDepart}")
                      ->whereRaw("CAST(SUBSTRING(departureTime, 1, 2) AS SIGNED) <= {$hourArrival}");
            });
        }

        $flights = $flightsQuery->get();
        $totalFlights = count($flights);

        $result = [
            'total_flight' => $totalFlights,
            'flight' => $flights
        ];

        return response()->json($result);
    } catch (\Exception $ex) {
        return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
    }
}




}
