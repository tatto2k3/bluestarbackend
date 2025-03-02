<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Luggage;

class LuggageController extends Controller
{
    function addLuggage(Request $request){
        $Luggage = new Luggage;
        $Luggage->LUGGAGE_CODE = $request->input('LUGGAGE_CODE');
        $Luggage->MASS = $request->input('MASS');
        $Luggage->PRICE = $request->input('PRICE');
        $Luggage->save();

        return $Luggage;
    }

    function getLuggages()
    {
        $Luggages = Luggage::all();
         return response()->json($Luggages);
    }
    function updateLuggage(Request $request){
        
        try {
        // Validate the request data as needed
            $request->validate([
                'LUGGAGE_CODE' => 'required',
                'MASS' => 'required',
                'PRICE' => 'required',
            ]);

            // Find the Luggage by cId
            $Luggage = Luggage::where('LUGGAGE_CODE', $request->input('LUGGAGE_CODE'))->first();

            if (!$Luggage) {
                return response()->json(['error' => 'Luggage not found'], 404);
            }

            // Update Luggage data
            $Luggage->MASS = $request->input('MASS');
            $Luggage->PRICE = $request->input('PRICE');
            $Luggage->save();

            return response()->json(['message' => 'Luggage updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(($e->getMessage()), 500);
        }
    }


    function getLuggageDetails(Request $request)
    {
        $selectedLuggages = $request->input('luggage_Ids');

        // Chuyển chuỗi cIds thành mảng
        $selectedLuggageIds = explode(',', $selectedLuggages);

        // Lấy chi tiết của các khách hàng được chọn
        $LuggageDetails = Luggage::whereIn('LUGGAGE_CODE', $selectedLuggageIds)->get();

        return response()->json($LuggageDetails);
    }

    function deleteLuggage($cId)
    {
        try {
            // Tìm khách hàng dựa trên C_ID
            $Luggage = Luggage::where('LUGGAGE_CODE', $cId)->first();

            if (!$Luggage) {
                return response()->json(['error' => 'Luggage not found'], 404);
            }

            // Xóa khách hàng
            $Luggage->delete();

            return response()->json(['message' => 'Luggage deleted successfully'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function searchLuggages(Request $request)
    {
        try {
            $searchKeyword = $request->input('searchKeyword');

            if (empty($searchKeyword)) {
                return response()->json(['error' => 'Invalid search keyword'], 400);
            }

            // Search Luggages by name containing the provided keyword
            $searchResults = Luggage::where('LUGGAGE_CODE', 'like', '%' . $searchKeyword . '%')
                ->orWhere('MASS', 'like', '%' . $searchKeyword . '%')
                ->orWhere('PRICE', 'like', '%' . $searchKeyword . '%')
                ->get();

            return response()->json($searchResults);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
        }
    }



}
