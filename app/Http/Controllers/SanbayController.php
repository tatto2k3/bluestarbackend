<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sanbay;

class SanbayController extends Controller
{
    

    function getSanbays()
    {
        $Sanbays = Sanbay::all();
         return response()->json($Sanbays);
    }
    function updateSanbay(Request $request){
        
        try {
        // Validate the request data as needed
            $request->validate([
                'airportID' => 'required',
                'airportName' => 'required',
                'place' => 'required',
            ]);

            // Find the Sanbay by cId
            $Sanbay = Sanbay::where('airportID', $request->input('airportID'))->first();

            if (!$Sanbay) {
                return response()->json(['error' => 'Sanbay not found'], 404);
            }

            // Update Sanbay data
            $Sanbay->airportName = $request->input('airportName');
            $Sanbay->place = $request->input('place');
            $Sanbay->save();

            return response()->json(['message' => 'Sanbay updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(($e->getMessage()), 500);
        }
    }


    function getSanbayDetails(Request $request)
    {
        $selectedSanbays = $request->input('airportIds');

        // Chuyển chuỗi cIds thành mảng
        $selectedairportIDs = explode(',', $selectedSanbays);

        // Lấy chi tiết của các khách hàng được chọn
        $SanbayDetails = Sanbay::whereIn('airportID', $selectedairportIDs)->get();

        return response()->json($SanbayDetails);
    }

    function deleteSanbay($cId)
    {
        try {
            // Tìm khách hàng dựa trên C_ID
            $Sanbay = Sanbay::where('airportID', $cId)->first();

            if (!$Sanbay) {
                return response()->json(['error' => 'Sanbay not found'], 404);
            }

            // Xóa khách hàng
            $Sanbay->delete();

            return response()->json(['message' => 'Sanbay deleted successfully'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function searchSanbays(Request $request)
    {
        try {
            $searchKeyword = $request->input('searchKeyword');

            if (empty($searchKeyword)) {
                return response()->json(['error' => 'Invalid search keyword'], 400);
            }

            // Search Sanbays by name containing the provided keyword
            $searchResults = Sanbay::where('airportID', 'like', '%' . $searchKeyword . '%')
                ->orWhere('airportName', 'like', '%' . $searchKeyword . '%')
                ->orWhere('place', 'like', '%' . $searchKeyword . '%')
                ->get();

            return response()->json($searchResults);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
        }
    }
    public function getAllAirport()
    {
        try {
            $Sanbays = Sanbay::all();

            if (empty($Sanbays)) {
                return response()->json(['message' => 'Không có sân bay nào được tìm thấy'], 404);
            }

            return response()->json($Sanbays, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

    public function getAirportById($id)
    {
        try {
            $airport = Sanbay::where('airportID', $id)->first();

            if (!$airport) {
                return response()->json(['message' => "Không tìm thấy sân bay với ID $id"], 404);
            }

            return response()->json($airport, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error: ' . $e->getMessage()], 500);
        }
    }

}
