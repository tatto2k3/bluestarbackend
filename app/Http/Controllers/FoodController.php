<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class FoodController extends Controller
{
    function addFood(Request $request){
        $Food = new Food;
        $Food->f_id = $request->input('F_ID');
        $Food->f_name = $request->input('F_NAME');
        $Food->f_price = $request->input('F_PRICE');
        $Food->save();

        return $Food;
    }

    function getFoods()
    {
        $Foods = Food::all();
         return response()->json($Foods);
    }
    function updateFood(Request $request){
        
        try {
        // Validate the request data as needed
            $request->validate([
                'F_ID' => 'required',
                'F_NAME' => 'required',
                'F_PRICE' => 'required',
            ]);

            // Find the Food by cId
            $Food = Food::where('F_ID', $request->input('F_ID'))->first();

            if (!$Food) {
                return response()->json(['error' => 'Food not found'], 404);
            }

            // Update Food data
            $Food->F_NAME = $request->input('F_NAME');
            $Food->F_PRICE = $request->input('F_PRICE');
            $Food->save();

            return response()->json(['message' => 'Food updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(($e->getMessage()), 500);
        }
    }


    function getFoodDetails(Request $request)
    {
        $selectedFoods = $request->input('fIds');

        // Chuyển chuỗi cIds thành mảng
        $selectedFoodIds = explode(',', $selectedFoods);

        // Lấy chi tiết của các khách hàng được chọn
        $FoodDetails = Food::whereIn('F_ID', $selectedFoodIds)->get();

        return response()->json($FoodDetails);
    }

    function deleteFood($cId)
    {
        try {
            // Tìm khách hàng dựa trên C_ID
            $Food = Food::where('F_ID', $cId)->first();

            if (!$Food) {
                return response()->json(['error' => 'Food not found'], 404);
            }

            // Xóa khách hàng
            $Food->delete();

            return response()->json(['message' => 'Food deleted successfully'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function searchFoods(Request $request)
    {
        try {
            $searchKeyword = $request->input('searchKeyword');

            if (empty($searchKeyword)) {
                return response()->json(['error' => 'Invalid search keyword'], 400);
            }

            // Search Foods by name containing the provided keyword
            $searchResults = Food::where('F_PRICE', 'like', '%' . $searchKeyword . '%')
                ->orWhere('F_NAME', 'like', '%' . $searchKeyword . '%')
                ->orWhere('F_ID', 'like', '%' . $searchKeyword . '%')
                ->get();

            return response()->json($searchResults);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
        }
    }



}
