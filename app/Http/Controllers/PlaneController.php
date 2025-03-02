<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plane;

class PlaneController extends Controller
{
    function addPlane(Request $request){
        $Plane = new Plane;
        $Plane->pl_id = $request->input('PL_ID');
        $Plane->typeofplane = $request->input('TYPEOFPLANE');
        $Plane->business_capacity = $request->input('BUSINESS_CAPACITY');
        $Plane->economy_capacity = $request->input('ECONOMY_CAPACITY');
        $Plane->save();

        return $Plane;
    }

    function getPlanes()
    {
        $Planes = Plane::all();
         return response()->json($Planes);
    }
    function updatePlane(Request $request){
        
        try {
        // Validate the request data as needed
            $request->validate([
                'PL_ID' => 'required',
                'TYPEOFPLANE' => 'required',
                'BUSINESS_CAPACITY' => 'required',
                'ECONOMY_CAPACITY' => 'required',
            ]);

            // Find the Plane by cId
            $Plane = Plane::where('PL_ID', $request->input('PL_ID'))->first();

            if (!$Plane) {
                return response()->json(['error' => 'Plane not found'], 404);
            }

            // Update Plane data
            $Plane->TYPEOFPLANE = $request->input('TYPEOFPLANE');
            $Plane->BUSINESS_CAPACITY = $request->input('BUSINESS_CAPACITY');
            $Plane->ECONOMY_CAPACITY = $request->input('ECONOMY_CAPACITY');
            $Plane->save();

            return response()->json(['message' => 'Plane updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(($e->getMessage()), 500);
        }
    }


    function getPlaneDetails(Request $request)
    {
        $selectedPlanes = $request->input('plIds');

        // Chuyển chuỗi cIds thành mảng
        $selectedPlaneIds = explode(',', $selectedPlanes);

        // Lấy chi tiết của các khách hàng được chọn
        $PlaneDetails = Plane::whereIn('PL_ID', $selectedPlaneIds)->get();

        return response()->json($PlaneDetails);
    }

    function deletePlane($plId)
    {
        try {
            // Tìm khách hàng dựa trên C_ID
            $Plane = Plane::where('PL_ID', $plId)->first();

            if (!$Plane) {
                return response()->json(['error' => 'Plane not found'], 404);
            }

            // Xóa khách hàng
            $Plane->delete();

            return response()->json(['message' => 'Plane deleted successfully'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function searchPlanes(Request $request)
    {
        try {
            $searchKeyword = $request->input('searchKeyword');

            if (empty($searchKeyword)) {
                return response()->json(['error' => 'Invalid search keyword'], 400);
            }

            // Search Planes by name containing the provided keyword
            $searchResults = Plane::where('PL_ID', 'like', '%' . $searchKeyword . '%')
                ->orWhere('TYPEOFPLANE', 'like', '%' . $searchKeyword . '%')
                ->get();

            return response()->json($searchResults);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
        }
    }



}
