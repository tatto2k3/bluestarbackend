<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use DateTime;
use Carbon\Carbon;

class FlightController extends Controller
{
    function addFlight(Request $request)
    {
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

    function getExploreFlights()
    {
        $today = Carbon::today();
        $flights = Flight::with(['fromAirport', 'toAirport'])->whereDate('departureDay', '>=', $today)->get();
        return response()->json($flights);
    }
    function updateFlight(Request $request)
    {
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

    public function getFlightDetails($flyId)
    {
        $flight = Flight::where('id', $flyId)->first();

        if (!$flight) {
            return response()->json(['message' => 'Không tìm thấy chuyến bay'], 404);
        }

        return response()->json($flight);
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
            $validatedData = $request->validate([
                'fromLocation' => 'required|string',
                'toLocation' => 'required|string',
                'departureDay' => 'required|date',
                'departureTime' => 'nullable|string',
                'arrivalTime' => 'nullable|string'
            ]);

            $flightsQuery = Flight::with(['fromAirport', 'toAirport']) 
                ->where('fromLocation', $validatedData['fromLocation'])
                ->where('toLocation', $validatedData['toLocation'])
                ->whereDate('departureDay', $validatedData['departureDay']);

            if (!empty($validatedData['departureTime']) && !empty($validatedData['arrivalTime'])) {
                $hourDepart = (int) substr($validatedData['departureTime'], 0, 2);
                $hourArrival = (int) substr($validatedData['arrivalTime'], 0, 2);

                $flightsQuery->whereRaw("HOUR(departureTime) BETWEEN ? AND ?", [$hourDepart, $hourArrival]);
            }

            $flights = $flightsQuery->get();

            return response()->json([
                'total_flight' => $flights->count(),
                'flights' => $flights
            ]);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
        }
    }
}
