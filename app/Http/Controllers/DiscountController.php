<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    function addDiscount(Request $request){
        $Discount = new Discount;
        $Discount->D_ID = $request->input('D_ID');
        $Discount->D_NAME = $request->input('D_NAME');
        $Discount->D_START = $request->input('D_START');
        $Discount->D_FINISH = $request->input('D_FINISH');
        $Discount->D_PERCENT = $request->input('D_PERCENT');
        $Discount->save();

        return $Discount;
    }

    function getDiscounts()
    {
        $Discounts = Discount::all();
         return response()->json($Discounts);
    }
    function updateDiscount(Request $request){
        
        try {
        // Validate the request data as needed
            $request->validate([
                'D_ID' => 'required',
                'D_NAME' => 'required',
                'D_START' => 'required',
                'D_FINISH' => 'required',
                'D_PERCENT' => 'required',
            ]);

            // Find the Discount by cId
            $Discount = Discount::where('D_ID', $request->input('D_ID'))->first();

            if (!$Discount) {
                return response()->json(['error' => 'Discount not found'], 404);
            }

            // Update Discount data
            $Discount->D_NAME = $request->input('D_NAME');
            $Discount->D_START = $request->input('D_START');
            $Discount->D_FINISH = $request->input('D_FINISH');
            $Discount->D_PERCENT = $request->input('D_PERCENT');
            $Discount->save();

            return response()->json(['message' => 'Discount updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(($e->getMessage()), 500);
        }
    }


    function getDiscountDetails(Request $request)
    {
        $selectedDiscounts = $request->input('dIds');

        // Chuyển chuỗi cIds thành mảng
        $selectedDiscountIds = explode(',', $selectedDiscounts);

        // Lấy chi tiết của các khách hàng được chọn
        $DiscountDetails = Discount::whereIn('D_ID', $selectedDiscountIds)->get();

        return response()->json($DiscountDetails);
    }

    function deleteDiscount($cId)
    {
        try {
            // Tìm khách hàng dựa trên C_ID
            $Discount = Discount::where('D_ID', $cId)->first();

            if (!$Discount) {
                return response()->json(['error' => 'Discount not found'], 404);
            }

            // Xóa khách hàng
            $Discount->delete();

            return response()->json(['message' => 'Discount deleted successfully'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function searchDiscounts(Request $request)
    {
        try {
            $searchKeyword = $request->input('searchKeyword');

            if (empty($searchKeyword)) {
                return response()->json(['error' => 'Invalid search keyword'], 400);
            }

            // Search Discounts by name containing the provided keyword
            $searchResults = Discount::where('D_ID', 'like', '%' . $searchKeyword . '%')
                ->orWhere('D_NAME', 'like', '%' . $searchKeyword . '%')
                ->orWhere('D_FINISH', 'like', '%' . $searchKeyword . '%')
                ->orWhere('D_START', 'like', '%' . $searchKeyword . '%')
                ->get();

            return response()->json($searchResults);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
        }
    }

    public function getDiscountById(Request $request)
    {
         $result = Discount::where ('D_ID', '=', $request->input('discountID'))->get();
         return ($result);
    }


}
